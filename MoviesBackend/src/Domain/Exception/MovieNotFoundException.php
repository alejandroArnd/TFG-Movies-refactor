<?php

namespace App\Domain\Exception;

use Exception;

class MovieNotFoundException extends Exception
{
    public function errorMessage()
    {
        return ["message" => "Movie was not found", "status" => 404];
    }
}