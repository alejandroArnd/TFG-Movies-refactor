<?php

namespace App\Domain\Exception;

use Exception;

class ReleaseDateIsNotAValidDateException extends Exception
{
    public function errorMessage()
    {
        return ["message" => "Invalid date format", "status" => 400];
    }
}