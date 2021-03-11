<?php

namespace App\Domain\Exception;

use Exception;

class ImageIsNotValidException extends Exception
{
    public function __construct()
    {
        parent::__construct("This image is not valid", 400);
    }
}