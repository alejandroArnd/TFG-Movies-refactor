<?php

namespace App\Domain\Exception;

use Exception;

class ReleaseDateIsNotAValidDateException extends Exception
{
    public function __construct()
    {
        parent::__construct("Invalid date format", 400);
    }
}