<?php

namespace App\Domain\Exception;

use Exception;

class EmailIsNotValidException extends Exception
{
    public function errorMessage()
    {
        return ["message" => "This email is not valid", "status" => 400];
    }
}