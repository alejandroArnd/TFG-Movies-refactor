<?php

namespace App\Tests\Application\UseCase\Movies;

use DateTime;
use ReflectionClass;
use PHPUnit\Framework\TestCase;
use App\Domain\Model\GenreModel;
use App\Domain\Model\MoviesModel;
use App\Application\Repository\MoviesRepository;
use App\Domain\Exception\MovieNotFoundException;
use App\Application\UseCases\Movies\SoftDeleteMovie;

class SoftDeleteMovieTest extends TestCase
{
    private MoviesRepository $moviesRepository;
    private SoftDeleteMovie $softDeleteMovie;

    public function setUp(): void
    {
        $this->moviesRepository = $this->createMock(MoviesRepository::class);
        $this->softDeleteMovie = new SoftDeleteMovie($this->moviesRepository);
    }

    public function testSoftDeleteMovieWhenIdDoesntExist(): void
    {
        $this->moviesRepository->expects($this->once())
            ->method('findById')
            ->with(1);
        
        $this->moviesRepository->expects($this->never())
            ->method('save');
        
        $this->expectException(MovieNotFoundException::class);

        $this->softDeleteMovie->handle(1);
    }

    public function testSoftDeleteMovieCorrectly(): void
    {
        $genreModel = new GenreModel('Action', 1);
        $movieModel = new MoviesModel('example', 'example', new DateTime('2021-02-01'), 3000, 1);

        $movieModel->addGenre($genreModel);

        $this->moviesRepository->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn($movieModel);
        
        $this->moviesRepository->expects($this->once())
            ->method('save')
            ->with($movieModel);
        
        
        $this->softDeleteMovie->handle(1);
        $this->assertTrue($movieModel->getIsDeleted());
    }
}
