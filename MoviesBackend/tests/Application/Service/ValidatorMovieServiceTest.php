<?php

namespace App\Tests\Application\Service;

use PHPUnit\Framework\TestCase;
use App\Domain\Exception\TitleLengthException;
use App\Domain\Exception\OverviewLengthException;
use App\Application\Service\ValidatorMovieService;
use App\Domain\Exception\ImageIsNotValidException;
use App\Domain\Exception\DurationIsNotValidNumberException;
use App\Domain\Exception\ReleaseDateIsNotAValidDateException;

class ValidatorMovieServiceTest extends TestCase
{
    private ValidatorMovieService $validatorMovie;

    public function setUp(): void
    {
        $this->validatorMovie = new ValidatorMovieService();
    }

    public function testvalidateMovieWhenReleaseDateIsNotValid(): void
    {
        $movie = json_decode('{
            "title" : "samle",
            "releaseDate" : "2021-20-01", 
            "duration" : 5000000, 
            "overview" : "example", 
            "genres" : ["Action", "War"],
            "image" : ""
        }');

        $movie = $this->setImageMovie($movie);

        $this->expectException(ReleaseDateIsNotAValidDateException::class);

        $this->validatorMovie->validate($movie);
    }

    public function testvalidateMovieWhenDurationIsNotValidPositiveNumber(): void
    {
        $movie = json_decode('{
            "title" : "samle",
            "releaseDate" : "2021-02-01", 
            "duration" : -5000000, 
            "overview" : "example", 
            "genres" : ["Action", "War"],
            "image" : ""
        }');

        $movie = $this->setImageMovie($movie);

        $this->expectException(DurationIsNotValidNumberException::class);

        $this->validatorMovie->validate($movie);
    }

    public function testvalidateMovieWhenOverviewLengthIsTooLong(): void
    {
        $movie = json_decode('{
            "title" : "samle",
            "releaseDate" : "2021-02-01", 
            "duration" : 5000000, 
            "overview" : "exampleexample", 
            "genres" : ["Action", "War"],
            "image" : ""
        }');

        $movie->overview = $this->setMoreCharacters($movie->overview);

        $movie = $this->setImageMovie($movie);

        $this->expectException(OverviewLengthException::class);

        $this->validatorMovie->validate($movie);
    }

    public function testValidateMovieWhenTitleLengthIsTooLong(): void
    {
        $movie = json_decode('{
            "title" : "samle",
            "releaseDate" : "2021-02-01", 
            "duration" : 5000000, 
            "overview" : "exampleexample", 
            "genres" : ["Action", "War"],
            "image" : ""
        }');

        $movie->title = $this->setMoreCharacters($movie->title);

        $movie = $this->setImageMovie($movie);

        $this->expectException(TitleLengthException::class);

        $this->validatorMovie->validate($movie);
    }

    private function setMoreCharacters($stringToSetMoreCharacters)
    {
        for($i = 1; $i <= 15; $i++){
            $stringToSetMoreCharacters .= $stringToSetMoreCharacters;
        }
        return $stringToSetMoreCharacters;
    }

    public function testvalidateMovieWhenImageIsNotValidBase64(): void
    {
        $movie = json_decode('{
            "title" : "samle",
            "releaseDate" : "2021-02-01", 
            "duration" : 5000000, 
            "overview" : "example", 
            "genres" : ["Action", "War"],
            "image" : "NOTBASE64"
        }');

        $this->expectException(ImageIsNotValidException::class);

        $this->validatorMovie->validate($movie);
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