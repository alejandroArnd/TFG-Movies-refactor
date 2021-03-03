<?php

namespace App\Tests\Application\UseCase\Movies;

use DateTime;
use PHPUnit\Framework\TestCase;
use App\Domain\Model\GenreModel;
use App\Domain\Model\MoviesModel;
use App\Application\Repository\GenreRepository;
use App\Application\Repository\MoviesRepository;
use App\Application\UseCases\Movies\CreateMovie;

class CreateMoviesTest extends TestCase
{
    public function testCreateMovieCorrectly()
    {
        $movie = json_decode('{
            "title" : "samle",
            "releaseDate" : "2021-02-02", 
            "duration" : 5000000, 
            "overview" : "example", 
            "genres" : ["Action", "War"]
        }');

        $movieModel = new MoviesModel($movie->title, $movie->overview, new DateTime($movie->releaseDate), $movie->duration);

        $genreActionModel = $this->createMock(GenreModel::class);
        $genreWarModel = $this->createMock(GenreModel::class);

        $movieModel->addGenre($genreActionModel);
        $movieModel->addGenre($genreWarModel);

        $moviesRepository = $this->createMock(MoviesRepository::class);
        $genreRepository = $this->createMock(GenreRepository::class);

        $createMoview = new CreateMovie($moviesRepository, $genreRepository);

        $moviesRepository->expects($this->once())
            ->method('findOneByTitle')
            ->with($movie->title);
        
        $genreRepository->expects($this->exactly(2))
            ->method('findOneByName')
            ->withConsecutive(["Action"], [ "War"])
            ->willReturnOnConsecutiveCalls($genreActionModel, $genreWarModel);
        
        $moviesRepository->expects($this->once())->method('save')->with($movieModel);

        $createMoview->handle($movie);
    }
}