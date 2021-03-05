<?php

namespace App\Tests\Application\UseCase\Movies;

use DateTime;
use ReflectionProperty;
use PHPUnit\Framework\TestCase;
use App\Domain\Model\GenreModel;
use App\Domain\Model\MoviesModel;
use App\Application\Repository\GenreRepository;
use App\Application\Repository\MoviesRepository;
use App\Application\UseCases\Movies\UpdateMovie;
use App\Domain\Exception\GenreNotFoundException;
use App\Domain\Exception\MovieNotFoundException;
use App\Domain\Exception\MovieAlreadyExistException;

class UpdateMovieTest extends TestCase
{
    private MoviesRepository $moviesRepository;
    private GenreRepository $genreRepository;
    private UpdateMovie $updateMovie;

    public function setUp(): void
    {
        $this->moviesRepository = $this->createMock(MoviesRepository::class);
        $this->genreRepository = $this->createMock(GenreRepository::class);
        $this->updateMovie = new UpdateMovie($this->moviesRepository, $this->genreRepository);
    }

    public function testUpdateMovieCorrectly(): void
    {
        $movie = json_decode('{
            "id" : 1,
            "title" : "samle",
            "releaseDate" : "2021-02-02", 
            "duration" : 5000000, 
            "overview" : "example", 
            "genres" : ["Action", "War"]
        }');
        
        $movieModelExpected = new MoviesModel('example', 'overview', new DateTime('2020-01-12'), 3000);

        $reflectionProperty = new ReflectionProperty(MoviesModel::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($movieModelExpected, $movie->id);
        $reflectionProperty->setAccessible(false);

        $genreActionModel = new GenreModel('Action', 1);
        $genreWarModel = new GenreModel('War', 2);

        $movieModelExpected->addGenre($genreActionModel);

        $this->moviesRepository->expects($this->once())
            ->method('findById')
            ->with($movie->id)
            ->willReturn($movieModelExpected);
        
        $this->moviesRepository->expects($this->once())
            ->method('findOneByTitle')
            ->with($movie->title);
        
        $this->genreRepository->expects($this->exactly(2))
            ->method('findOneByName')
            ->withConsecutive(["Action"], [ "War"])
            ->willReturnOnConsecutiveCalls($genreActionModel, $genreWarModel);
        
        $this->moviesRepository->expects($this->once())
            ->method('save')
            ->with($movieModelExpected);

        $this->updateMovie->handle($movie);

        $this->assertContains($genreWarModel, $movieModelExpected->getGenres());
        $this->assertEquals($movie->title, $movieModelExpected->getTitle());
        $this->assertEquals(new DateTime($movie->releaseDate), $movieModelExpected->getReleaseDate());
        $this->assertEquals($movie->duration, $movieModelExpected->getDuration());
        $this->assertEquals($movie->overview, $movieModelExpected->getOverview());
    }

    public function testUpdateMovieWhenIdDoesntExist(): void
    {
        $movie = json_decode('{
            "id" : 2,
            "title" : "samle",
            "releaseDate" : "2021-02-02", 
            "duration" : 5000000, 
            "overview" : "example", 
            "genres" : ["Action", "War"]
        }');

        $this->moviesRepository->expects($this->once())
            ->method('findById')
            ->with($movie->id);
        
        $this->moviesRepository->expects($this->never())
            ->method('findOneByTitle');
        
        $this->genreRepository->expects($this->never())
            ->method('findOneByName');
        
        $this->moviesRepository->expects($this->never())
            ->method('save');
        
        $this->expectException(MovieNotFoundException::class);

        $this->updateMovie->handle($movie);
    }

    public function testUpdateMovieWhenTitleAlreadyExist(): void
    {
        $movie = json_decode('{
            "id" : 1,
            "title" : "example",
            "releaseDate" : "2021-02-02", 
            "duration" : 5000000, 
            "overview" : "example", 
            "genres" : ["Action", "War"]
        }');

        $movieModelAlreadyExist = new MoviesModel('example', 'overview', new DateTime('2020-01-12'), 3000);
        $movieModelFound = new MoviesModel('exampleTest', 'overview', new DateTime('2020-01-12'), 3000);

        $reflectionProperty = new ReflectionProperty(MoviesModel::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($movieModelAlreadyExist, 2);
        $reflectionProperty->setValue($movieModelFound, 1);
        $reflectionProperty->setAccessible(false);

        $genreActionModel = new GenreModel('Action', 1);

        $movieModelAlreadyExist->addGenre($genreActionModel);
        $movieModelFound->addGenre($genreActionModel);

        $this->moviesRepository->expects($this->once())
            ->method('findById')
            ->with($movie->id)
            ->willReturn($movieModelFound);
        
        $this->moviesRepository->expects($this->once())
            ->method('findOneByTitle')
            ->with($movie->title)
            ->willReturn($movieModelAlreadyExist);
        
        $this->genreRepository->expects($this->never())
            ->method('findOneByName');
        
        $this->moviesRepository->expects($this->never())
            ->method('save');
        
        $this->expectException(MovieAlreadyExistException::class);

        $this->updateMovie->handle($movie);
    }

    public function testUpdateMovieWhenGenreDoesntExist(): void
    {
        $movie = json_decode('{
            "id" : 1,
            "title" : "samle",
            "releaseDate" : "2021-02-02", 
            "duration" : 5000000, 
            "overview" : "example", 
            "genres" : ["Action", "Warr"]
        }');
        
        $movieModelExpected = new MoviesModel('example', 'overview', new DateTime('2020-01-12'), 3000);

        $reflectionProperty = new ReflectionProperty(MoviesModel::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($movieModelExpected, $movie->id);
        $reflectionProperty->setAccessible(false);

        $genreActionModel = new GenreModel('Action', 1);

        $movieModelExpected->addGenre($genreActionModel);

        $this->moviesRepository->expects($this->once())
            ->method('findById')
            ->with($movie->id)
            ->willReturn($movieModelExpected);
        
        $this->moviesRepository->expects($this->once())
            ->method('findOneByTitle')
            ->with($movie->title);
        
        $this->genreRepository->expects($this->exactly(2))
            ->method('findOneByName')
            ->withConsecutive(["Action"], [ "Warr"])
            ->willReturnOnConsecutiveCalls($genreActionModel);
        
        $this->moviesRepository->expects($this->never())
            ->method('save');

        $this->expectException(GenreNotFoundException::class);

        $this->updateMovie->handle($movie);
    }
}