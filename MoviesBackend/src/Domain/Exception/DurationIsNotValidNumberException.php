<?php

namespace App\Domain\Exception;

use Exception;

class DurationIsNotValidNumberException extends Exception
{
    public function errorMessage()
    {
        return ["message" => "Duration must be a positive number", "status" => 400];
    }
}