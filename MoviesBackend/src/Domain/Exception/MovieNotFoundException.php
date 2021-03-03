<?php

namespace App\Domain\Exception;

use Exception;

class MovieNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct("Movie was not found", 404);
    }
}