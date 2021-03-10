<?php

namespace App\Tests\Application\UseCase\Movies;

use DateTime;
use PHPUnit\Framework\TestCase;
use App\Domain\Model\GenreModel;
use App\Domain\Model\MoviesModel;
use App\Application\Repository\MoviesRepository;
use App\Application\UseCases\Movies\FindMoviesByTitle;
use App\Application\Dto\Response\MovieSearchResponseDto;
use App\Application\Dto\Response\Transformer\MovieSearchResponseDtoTransformer;

class FindMoviesByTitleTest extends TestCase
{
    private MoviesRepository $moviesRepository;
    private MovieSearchResponseDtoTransformer $movieSearchResponseDtoTransformer;
    private FindMoviesByTitle $findMoviesByTitle;

    public function setUp(): void
    {
        $this->movieResponseDtoTransformer = $this->getMockBuilder(MovieSearchResponseDtoTransformer::class)
                                                  ->enableProxyingToOriginalMethods()
                                                  ->enableOriginalConstructor()
                                                  ->getMock();
        $this->moviesRepository = $this->createMock(MoviesRepository::class);
        $this->findMoviesByTitle = new FindMoviesByTitle($this->moviesRepository, $this->movieResponseDtoTransformer);
    }

    public function testFindMoviesByTitleCorrectly(): void
    {
        $moviesModel = $this->getAllMovieModelDataProvider();

        $moviesDtosExpected = $this->getAllMoviesDtosDataProvider();
        
        $this->moviesRepository->expects($this->once())
            ->method('findByTitle')
            ->willReturn($moviesModel);
        
        $this->movieResponseDtoTransformer->expects($this->once())
            ->method('transformFromObjects')
            ->with($moviesModel);
        
        $moviesReturned = $this->findMoviesByTitle->handle('ex');

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
        $movieDtoFirst = new MovieSearchResponseDto();
        $movieDtoFirst->setId(1);
        $movieDtoFirst->setTitle('example1');
        $movieDtoFirst->setAccessiblePath('http://localhost:9090/files/test1.jpg');

        $movieDtoSecond = new MovieSearchResponseDto();
        $movieDtoSecond->setId(2);
        $movieDtoSecond->setTitle('example2');
        $movieDtoSecond->setAccessiblePath('http://localhost:9090/files/test2.jpg');

        return  [$movieDtoFirst, $movieDtoSecond];
    }
}