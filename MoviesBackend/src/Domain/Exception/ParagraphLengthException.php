<?php

namespace App\Domain\Exception;

use Exception;

class ParagraphLengthException extends Exception
{
    public function __construct()
    {
        parent::__construct("Paragraph must have 1000 characters", 400);
    }
}