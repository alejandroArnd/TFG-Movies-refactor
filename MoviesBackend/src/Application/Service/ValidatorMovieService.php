<?php

namespace App\Application\Service;

use App\Domain\Exception\TitleLengthException;
use App\Domain\Exception\OverviewLengthException;
use App\Domain\Exception\DurationIsNotValidNumberException;
use App\Domain\Exception\ReleaseDateIsNotAValidDateException;

class ValidatorMovieService
{
    public function validate($movie)
    {
        if(!strtotime($movie->releaseDate)){
            throw new ReleaseDateIsNotAValidDateException();
        }

        if(!is_numeric($movie->duration) || $movie->duration < 0){
            throw new DurationIsNotValidNumberException();
        }

        if(strlen($movie->overview) > 1000){
            throw new OverviewLengthException();
        }

        if(strlen($movie->title) > 255){
            throw new TitleLengthException();
        }
    }
}