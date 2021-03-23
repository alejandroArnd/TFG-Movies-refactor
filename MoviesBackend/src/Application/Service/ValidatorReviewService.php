<?php

namespace App\Application\Service;

use App\Domain\Exception\TitleLengthException;
use App\Domain\Exception\ParagraphLengthException;
use App\Domain\Exception\ScoreIsNotValidNumberException;

class ValidatorReviewService
{
    public function validate($review)
    {
        if(!is_numeric($review->score) || ($review->score < 0 && $review->score > 10) || !preg_match('/^\d*}*(\.[5]{1})?$/', $review->score)){
            throw new ScoreIsNotValidNumberException();
        }

        if(strlen($review->paragraph) > 1000){
            throw new ParagraphLengthException();
        }

        if(strlen($review->title) > 255){
            throw new TitleLengthException();
        }
    }
}