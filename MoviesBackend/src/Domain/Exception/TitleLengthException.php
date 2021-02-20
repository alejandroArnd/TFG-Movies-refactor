<?php

namespace App\Domain\Exception;

use Exception;

class TitleLengthException extends Exception
{
    public function errorMessage()
    {
        return ["message" => "Title must have 255 characters", "status" => 400];
    }
}