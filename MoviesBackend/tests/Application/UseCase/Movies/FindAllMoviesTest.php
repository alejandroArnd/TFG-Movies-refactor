<?php

namespace App\Tests\Application\UseCase\Movies;

use DateTime;
use PHPUnit\Framework\TestCase;
use App\Domain\Model\GenreModel;
use App\Domain\Model\MoviesModel;
use App\Application\Repository\MoviesRepository;
use App\Application\Dto\Response\GenreResponseDto;
use App\Application\Dto\Response\MovieResponseDto;
use App\Application\UseCases\Movies\FindAllMovies;
use App\Application\Dto\Response\Transformer\GenreResponseDtoTransformer;
use App\Application\Dto\Response\Transformer\MovieResponseDtoTransformer;
use App\Application\Dto\Response\Transformer\ReviewResponseDtoTransformer;

class FindAllMoviesTest extends TestCase
{
    private MoviesRepository $moviesRepository;
    private MovieResponseDtoTransformer $movieResponseDtoTransformer;
    private FindAllMovies $findAllMovies;
    private GenreResponseDtoTransformer $genreResponseDtoTransformer;
    private ReviewResponseDtoTransformer $reviewResponseDtoTransformer;

    public function setUp(): void
    {
        $this->genreResponseDtoTransformer = $this->getMockBuilder(GenreResponseDtoTransformer::class)
                                                  ->enableProxyingToOriginalMethods()
                                                  ->enableOriginalConstructor()
                                                  ->getMock();

        $this->reviewResponseDtoTransformer = $this->createMock(ReviewResponseDtoTransformer::class);
        
        $this->movieResponseDtoTransformer = $this->getMockBuilder(MovieResponseDtoTransformer::class)
                                                  ->enableProxyingToOriginalMethods()
                                                  ->enableOriginalConstructor()
                                                  ->setConstructorArgs([$this->genreResponseDtoTransformer, $this->reviewResponseDtoTransformer])
                                                  ->getMock();

        $this->moviesRepository = $this->createMock(MoviesRepository::class);
        $this->findAllMovies = new FindAllMovies($this->moviesRepository, $this->movieResponseDtoTransformer);
    }

    public function testFindAllMoviesCorrectly(): void
    {
        $moviesModel = $this->getAllMovieModelDataProvider();

        $moviesDtosExpected = $this->getAllMoviesDtosDataProvider();
        
        $this->moviesRepository->expects($this->once())
            ->method('getAll')
            ->willReturn($moviesModel);
        
        $this->movieResponseDtoTransformer->expects($this->once())
            ->method('transformFromObjects')
            ->with($moviesModel);
        
        $moviesReturned = $this->findAllMovies->handle();

        $this->assertEquals($moviesDtosExpected, $moviesReturned);
    }

    public function getAllMovieModelDataProvider()
    {

        $genreModel = new GenreModel('Action', 1);

        $movieModelFirst = new MoviesModel('example1', 'example', new DateTime('2021-02-01'), 3000, 'http://localhost:9090/files/test1.jpg', 1);
        $movieModelFirst->addGenre($genreModel);

        $movieModelSecond = new MoviesModel('example2', 'example', new DateTime('2021-02-01'), 3600, 'http://localhost:9090/files/test2.jpg', 2);
        $movieModelSecond->addGenre($genreModel);

        return  [$movieModelFirst, $movieModelSecond];
    }

    public function getAllMoviesDtosDataProvider()
    {
        $genreDto = new GenreResponseDto();
        $genreDto->setName('Action');

        $movieDtoFirst = new MovieResponseDto();
        $movieDtoFirst->setId(1);
        $movieDtoFirst->setTitle('example1');
        $movieDtoFirst->setReleaseDate('2021-02-01');
        $movieDtoFirst->setOverview('example');
        $movieDtoFirst->setDuration(3000);
        $movieDtoFirst->setIsDeleted(false);
        $movieDtoFirst->setReviews([]);
        $movieDtoFirst->setGenres([$genreDto]);  
        $movieDtoFirst->setAccessiblePath('http://localhost:9090/files/test1.jpg');

        $movieDtoSecond = new MovieResponseDto();
        $movieDtoSecond->setId(2);
        $movieDtoSecond->setTitle('example2');
        $movieDtoSecond->setReleaseDate('2021-02-01');
        $movieDtoSecond->setOverview('example');
        $movieDtoSecond->setDuration(3600);
        $movieDtoSecond->setIsDeleted(false);
        $movieDtoSecond->setReviews([]);
        $movieDtoSecond->setGenres([$genreDto]);
        $movieDtoSecond->setAccessiblePath('http://localhost:9090/files/test2.jpg');  

        return  [$movieDtoFirst, $movieDtoSecond];
    }
}