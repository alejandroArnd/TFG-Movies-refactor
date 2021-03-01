<?php

namespace App\Domain\Exception;

use Exception;

class UsernameAlreadyExistException extends Exception
{
    public function errorMessage()
    {
        return ["message" => "This username already exist", "status" => 400];
    }
}