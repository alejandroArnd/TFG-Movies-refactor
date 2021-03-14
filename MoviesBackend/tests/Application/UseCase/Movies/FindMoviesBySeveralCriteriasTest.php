<?php

namespace App\Tests\Application\UseCase\Movies;

use DateTime;
use PHPUnit\Framework\TestCase;
use App\Domain\Model\GenreModel;
use App\Domain\Model\MoviesModel;
use App\Application\Repository\MoviesRepository;
use App\Application\Dto\Response\SearchResponseDto;
use App\Application\UseCases\Movies\FindMoviesBySeveralCriterias;
use App\Application\Dto\Response\MovieSearchResponseDto;
use App\Application\Dto\Response\Transformer\SearchResponseDtoTransformer;
use App\Application\Dto\Response\Transformer\MovieSearchResponseDtoTransformer;

class FindMoviesBySeveralCriteriasTest extends TestCase
{
    private MoviesRepository $moviesRepository;
    private SearchResponseDtoTransformer $searchResponseDtoTransformer;
    private FindMoviesBySeveralCriterias $findMoviesBySeveralCriterias;
    private MovieSearchResponseDtoTransformer $movieSearchResponseDtoTransformer;

    public function setUp(): void
    {
        $this->movieSearchResponseDtoTransformer = $this->getMockBuilder(MovieSearchResponseDtoTransformer::class)
                                                  ->enableProxyingToOriginalMethods()
                                                  ->enableOriginalConstructor()
                                                  ->getMock();

        $this->searchResponseDtoTransformer = $this->getMockBuilder(SearchResponseDtoTransformer::class)
                                                  ->enableProxyingToOriginalMethods()
                                                  ->enableOriginalConstructor()
                                                  ->setConstructorArgs([$this->movieSearchResponseDtoTransformer])
                                                  ->getMock();

        $this->moviesRepository = $this->createMock(MoviesRepository::class);
        $this->findMoviesBySeveralCriterias = new FindMoviesBySeveralCriterias($this->moviesRepository, $this->searchResponseDtoTransformer);
    }

    public function testFindMoviesBySeveralCriteriasCorrectly(): void
    {
        $movie = json_decode('{
            "title" : "ex", 
            "genres" : ["NotGenre"],
            "page" : 1
        }');

        $searchResponse = $this->getAllMovieModelDataProvider();

        $searchResponseExpected = $this->getAllMoviesDtosDataProvider();
        
        $this->moviesRepository->expects($this->once())
            ->method('findMoviesBySeveralCriterias')
            ->willReturn($searchResponse);
        
        $this->searchResponseDtoTransformer->expects($this->once())
            ->method('transformFromObject')
            ->with($searchResponse);
        
        $searchResponseReturned = $this->findMoviesBySeveralCriterias->handle($movie);

        $this->assertEquals($searchResponseExpected, $searchResponseReturned);
        $this->assertEquals($searchResponseExpected->getTotalItems(), $searchResponseReturned->getTotalItems());
    }

    public function getAllMovieModelDataProvider()
    {

        $genreModel = new GenreModel('Action', 1);

        $movieModelFirst = new MoviesModel('example1', 'example', new DateTime('2021-02-01'), 3000, 'http://localhost:9090/files/test1.jpg', 1);
        $movieModelFirst->addGenre($genreModel);

        $movieModelSecond = new MoviesModel('example2', 'example', new DateTime('2021-02-01'), 3600, 'http://localhost:9090/files/test2.jpg', 2);
        $movieModelSecond->addGenre($genreModel);

        return (object) ['movies' => [$movieModelFirst, $movieModelSecond], 'totalItems' => 2];
        
    }

    public function getAllMoviesDtosDataProvider()
    {
        $movieDtoFirst = new MovieSearchResponseDto();
        $movieDtoFirst->setId(1);
        $movieDtoFirst->setTitle('example1');
        $movieDtoFirst->setAccessiblePath('http://localhost:9090/files/test1.jpg');

        $movieDtoSecond = new MovieSearchResponseDto();
        $movieDtoSecond->setId(2);
        $movieDtoSecond->setTitle('example2');
        $movieDtoSecond->setAccessiblePath('http://localhost:9090/files/test2.jpg');

        $searchResponseDto = new SearchResponseDto();
        $searchResponseDto->setMoviesSearch([$movieDtoFirst, $movieDtoSecond]);
        $searchResponseDto->setTotalItems(2);

        return $searchResponseDto;
    }
}