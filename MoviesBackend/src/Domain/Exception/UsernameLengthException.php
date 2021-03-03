<?php

namespace App\Domain\Exception;

use Exception;

class UsernameLengthException extends Exception
{
    public function __construct()
    {
        parent::__construct("Username must have 180 characters", 400);
    }
}