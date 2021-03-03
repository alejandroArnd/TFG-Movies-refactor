<?php

namespace App\Domain\Exception;

use Exception;

class TitleLengthException extends Exception
{
    public function __construct()
    {
        parent::__construct("Title must have 255 characters", 400);
    }
}