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
use App\Application\Service\ManageUploadFileService;
use App\Domain\Exception\MovieAlreadyExistException;

class CreateMovieTest extends TestCase
{
    private MoviesRepository $moviesRepository;
    private GenreRepository $genreRepository;
    private CreateMovie $createMovie;
    private ManageUploadFileService $manageUploadFileService;

    public function setUp(): void
    {
        $this->moviesRepository = $this->createMock(MoviesRepository::class);
        $this->genreRepository = $this->createMock(GenreRepository::class);
        $this->manageUploadFileService = $this->createMock(ManageUploadFileService::class);
        $this->createMovie = new CreateMovie($this->moviesRepository, $this->genreRepository, $this->manageUploadFileService);
    }

    public function testCreateMovieCorrectly(): void
    {
        $movie = json_decode('{
            "title" : "samle",
            "releaseDate" : "2021-02-02", 
            "duration" : 5000000, 
            "overview" : "example", 
            "genres" : ["Action", "War"],
            "image" : ""
        }');

        $movie = $this->setImageMovie($movie);

        $movieModel = new MoviesModel($movie->title, $movie->overview, new DateTime($movie->releaseDate), $movie->duration, 'http://localhost:9090/files/test1.jpg');

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

        $this->manageUploadFileService->expects($this->once())
            ->method('uploadFileFromBase64')
            ->with('/var/www/html/uploadMovieImages/', $movie)
            ->willReturn('http://localhost:9090/files/test1.jpg');
        
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
            "genres" : ["Action", "War"],
            "image" : ""
        }');

        $movie = $this->setImageMovie($movie);

        $movieMock = $this->createMock(MoviesModel::class);

        $this->moviesRepository->expects($this->once())
            ->method('findOneByTitle')
            ->with($movie->title)
            ->willReturn($movieMock);
        
        $this->genreRepository->expects($this->never())
            ->method('findOneByName');
        
        $this->manageUploadFileService->expects($this->never())
            ->method('uploadFileFromBase64');
        
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
            "genres" : ["NotGenre"],
            "image" : ""
        }');

        $movie = $this->setImageMovie($movie);

        $this->moviesRepository->expects($this->once())
            ->method('findOneByTitle')
            ->with($movie->title);
        
        $this->genreRepository->expects($this->exactly(1))
            ->method('findOneByName')
            ->with("NotGenre");
        
        $this->manageUploadFileService->expects($this->never())
            ->method('uploadFileFromBase64');
        
        $this->expectException(GenreNotFoundException::class);

        $this->createMovie->handle($movie);
    }

    public function setImageMovie($movie): object
    {
        $movie->image = "9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMDAsKCwsNDhIQDQ4RDgs
            LEBYQERMUFRUVDA8XGBYUGBIUFRT/2wBDAQMEBAUEBQkFBQkUDQsNFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQU
            FBQUFBQUFBQUFBQUFBT/wAARCAABAAEDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDA
            wIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISU
            pTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19j
            Z2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3
            AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZ
            GVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6On
            q8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD8rKKKKAP/2Q==";

        return $movie;
    }
}