<?php

namespace App\Domain\Exception;

use Exception;

class ParagraphLengthException extends Exception
{
    public function errorMessage()
    {
        return ["message" => "Paragraph must have 1000 characters", "status" => 400];
    }
}