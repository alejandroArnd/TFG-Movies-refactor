<?php

namespace App\Domain\Exception;

use Exception;

class DurationIsNotValidNumberException extends Exception
{
    public function __construct()
    {
        parent::__construct("Duration must be a positive number", 400);
    }
}