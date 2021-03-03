<?php

namespace App\Domain\Exception;

use Exception;

class MovieAlreadyExistException extends Exception
{
    public function __construct()
    {
        parent::__construct("This movie already exist", 400);
    }
}