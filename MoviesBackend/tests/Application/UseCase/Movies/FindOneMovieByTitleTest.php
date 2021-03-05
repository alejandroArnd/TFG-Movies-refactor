<?php

namespace App\Tests\Application\UseCase\Movies;

use DateTime;
use PHPUnit\Framework\TestCase;
use App\Domain\Model\GenreModel;
use App\Domain\Model\MoviesModel;
use App\Application\Repository\MoviesRepository;
use App\Domain\Exception\MovieNotFoundException;
use App\Application\Dto\Response\GenreResponseDto;
use App\Application\Dto\Response\MovieResponseDto;
use App\Application\UseCases\Movies\FindOneMovieByTitle;
use App\Application\Dto\Response\Transformer\GenreResponseDtoTransformer;
use App\Application\Dto\Response\Transformer\MovieResponseDtoTransformer;
use App\Application\Dto\Response\Transformer\ReviewResponseDtoTransformer;
use App\Application\Dto\Response\Transformer\MovieSearchResponseDtoTransformer;

class FindOneMovieByTitleTest extends TestCase
{
    private MoviesRepository $moviesRepository;
    private MovieSearchResponseDtoTransformer $movieSearchResponseDtoTransformer;
    private FindOneMovieByTitle $findOneMovieByTitle;

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
        $this->findOneMovieByTitle = new FindOneMovieByTitle($this->moviesRepository, $this->movieResponseDtoTransformer);
    }

    public function testFindOneMovieByTitleCorrectly(): void
    {
        $genreModel = new GenreModel('Action', 1);

        $movieModel = new MoviesModel('example1', 'example', new DateTime('2021-02-01'), 3000, 1);
        $movieModel->addGenre($genreModel);

        $genreDto = new GenreResponseDto();
        $genreDto->setName('Action');

        $movieDtoExpected = new MovieResponseDto();
        $movieDtoExpected->setId(1);
        $movieDtoExpected->setTitle('example1');
        $movieDtoExpected->setReleaseDate('2021-02-01');
        $movieDtoExpected->setOverview('example');
        $movieDtoExpected->setDuration(3000);
        $movieDtoExpected->setIsDeleted(false);
        $movieDtoExpected->setReviews([]);
        $movieDtoExpected->setGenres([$genreDto]);
        
        $this->moviesRepository->expects($this->once())
            ->method('findOneByTitle')
            ->with($movieModel->getTitle())
            ->willReturn($movieModel);
        
        $this->movieResponseDtoTransformer->expects($this->once())
            ->method('transformFromObject')
            ->with($movieModel);
        
        $movieReturned = $this->findOneMovieByTitle->handle('example1');

        $this->assertEquals($movieDtoExpected, $movieReturned);
    }

    public function testFindOneMovieByTitleWhenTitleDoesntExist(): void
    {
        $this->moviesRepository->expects($this->once())
        ->method('findOneByTitle');

        $this->movieResponseDtoTransformer->expects($this->never())
        ->method('transformFromObject');

        $this->expectException(MovieNotFoundException::class);

        $movieReturned = $this->findOneMovieByTitle->handle('example1');
    }

}