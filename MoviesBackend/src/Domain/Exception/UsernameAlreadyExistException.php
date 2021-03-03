<?php

namespace App\Domain\Exception;

use Exception;

class UsernameAlreadyExistException extends Exception
{
    public function __construct()
    {
        parent::__construct("This username already exist", 400);
    }
}