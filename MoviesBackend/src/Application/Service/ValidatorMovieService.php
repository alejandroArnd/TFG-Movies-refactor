<?php

namespace App\Application\Service;

use DateTime;
use App\Domain\Exception\TitleLengthException;
use App\Domain\Exception\OverviewLengthException;
use App\Domain\Exception\ImageIsNotValidException;
use App\Domain\Exception\DurationIsNotValidNumberException;
use App\Domain\Exception\ReleaseDateIsNotAValidDateException;

class ValidatorMovieService
{
    public function validate($movie)
    {
        if(!strtotime($movie->releaseDate) && !$this->validateDate($movie->releaseDate)){
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

        if(!$this->validateImageBase64($movie->image)){
            throw new ImageIsNotValidException();
        }
    }

    private function validateDate($date, $format = 'Y-m-d'): bool
    {
        $dataToValidate = DateTime::createFromFormat($format, $date);
        return $dataToValidate && $dataToValidate->format($format) === $date;
    }

    private function validateImageBase64($image): bool
    {
        return base64_decode($image, true);
    }
}