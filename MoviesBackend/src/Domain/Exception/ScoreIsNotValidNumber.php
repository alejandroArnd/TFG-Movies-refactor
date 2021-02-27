<?php

namespace App\Domain\Exception;

use Exception;

class ScoreIsNotValidNumberException extends Exception
{
    public function errorMessage()
    {
        return ["message" => "Score must be a positive number with one or zero decimal", "status" => 400];
    }
}