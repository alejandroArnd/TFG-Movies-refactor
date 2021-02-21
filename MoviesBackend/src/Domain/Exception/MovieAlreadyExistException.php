<?php

namespace App\Domain\Exception;

use Exception;

class MovieAlreadyExistException extends Exception
{
    public function errorMessage()
    {
        return ["message" => "This movie already exist", "status" => 400];
    }
}