<?php

namespace App\Domain\Exception;

use Exception;

class UsernameLengthException extends Exception
{
    public function errorMessage()
    {
        return ["message" => "Username must have 180 characters", "status" => 400];
    }
}