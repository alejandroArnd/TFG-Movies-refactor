<?php

namespace App\Domain\Exception;

use Exception;

class ScoreIsNotValidNumberException extends Exception
{
    public function __construct()
    {
        parent::__construct("Score must be a positive number with one or zero decimal", 400);
    }
}