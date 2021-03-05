<?php

namespace App\Tests\Application\Service;

use PHPUnit\Framework\TestCase;
use App\Domain\Exception\TitleLengthException;
use App\Domain\Exception\OverviewLengthException;
use App\Application\Service\ValidatorMovieService;
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
            "genres" : ["Action", "War"]
        }');

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
            "genres" : ["Action", "War"]
        }');

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
            "genres" : ["Action", "War"]
        }');

        $movie->overview = $this->setMoreCharacters($movie->overview);

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
            "genres" : ["Action", "War"]
        }');

        $movie->title = $this->setMoreCharacters($movie->title);

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
}