<?php

namespace App\Domain\Exception;

use Exception;

class EmailAlreadyInUseException extends Exception
{
    public function errorMessage()
    {
        return ["message" => "This email already in use", "status" => 400];
    }
}