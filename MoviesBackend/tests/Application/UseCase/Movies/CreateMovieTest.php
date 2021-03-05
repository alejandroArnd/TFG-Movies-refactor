<?php

namespace App\Tests\Application\UseCase\Movies;

use DateTime;
use PHPUnit\Framework\TestCase;
use App\Domain\Model\GenreModel;
use App\Domain\Model\MoviesModel;
use App\Application\Repository\GenreRepository;
use App\Application\Repository\MoviesRepository;
use App\Application\UseCases\Movies\CreateMovie;
use App\Domain\Exception\GenreNotFoundException;
use App\Domain\Exception\MovieAlreadyExistException;

class CreateMovieTest extends TestCase
{
    private MoviesRepository $moviesRepository;
    private GenreRepository $genreRepository;
    private CreateMovie $createMovie;

    public function setUp(): void
    {
        $this->moviesRepository = $this->createMock(MoviesRepository::class);
        $this->genreRepository = $this->createMock(GenreRepository::class);
        $this->createMovie = new CreateMovie($this->moviesRepository, $this->genreRepository);
    }


    public function testCreateMovieCorrectly(): void
    {
        $movie = json_decode('{
            "title" : "samle",
            "releaseDate" : "2021-02-02", 
            "duration" : 5000000, 
            "overview" : "example", 
            "genres" : ["Action", "War"]
        }');

        $movieModel = new MoviesModel($movie->title, $movie->overview, new DateTime($movie->releaseDate), $movie->duration);

        $genreActionModel = new GenreModel('Action', 1);
        $genreWarModel = new GenreModel('War', 2);

        $movieModel->addGenre($genreActionModel);
        $movieModel->addGenre($genreWarModel);

        $this->moviesRepository->expects($this->once())
            ->method('findOneByTitle')
            ->with($movie->title);
        
        $this->genreRepository->expects($this->exactly(2))
            ->method('findOneByName')
            ->withConsecutive(["Action"], [ "War"])
            ->willReturnOnConsecutiveCalls($genreActionModel, $genreWarModel);
        
        $this->moviesRepository->expects($this->once())->method('save')->with($movieModel);

        $this->createMovie->handle($movie);
    }

    public function testCreateMovieWhenTitleOfMovieAlreadyExist(): void
    {
        $movie = json_decode('{
            "title" : "samle",
            "releaseDate" : "2021-02-02", 
            "duration" : 5000000, 
            "overview" : "example", 
            "genres" : ["Action", "War"]
        }');

        $movieMock = $this->createMock(MoviesModel::class);

        $this->moviesRepository->expects($this->once())
            ->method('findOneByTitle')
            ->with($movie->title)
            ->willReturn($movieMock);
        
        $this->expectException(MovieAlreadyExistException::class);

        $this->createMovie->handle($movie);
    }

    public function testCreateMovieWhenOneGenreDoesntExist(): void
    {
        $movie = json_decode('{
            "title" : "samle",
            "releaseDate" : "2021-02-02", 
            "duration" : 5000000, 
            "overview" : "example", 
            "genres" : ["NotGenre"]
        }');

        $this->moviesRepository->expects($this->once())
            ->method('findOneByTitle')
            ->with($movie->title);
        
        $this->genreRepository->expects($this->exactly(1))
            ->method('findOneByName')
            ->with("NotGenre");

        $this->expectException(GenreNotFoundException::class);

        $this->createMovie->handle($movie);
    }
}