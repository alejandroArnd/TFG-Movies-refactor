<?php

namespace App\Domain\Exception;

use Exception;

class EmailIsNotValidException extends Exception
{
    public function __construct()
    {
        parent::__construct("This email is not valid", 400);
    }
}