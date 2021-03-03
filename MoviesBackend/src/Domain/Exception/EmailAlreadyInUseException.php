<?php

namespace App\Domain\Exception;

use Exception;

class EmailAlreadyInUseException extends Exception
{
    public function __construct()
    {
        parent::__construct("This email already in use", 400);
    }
}