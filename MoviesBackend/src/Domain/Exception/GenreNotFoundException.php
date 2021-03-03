<?php

namespace App\Domain\Exception;

use Exception;

class GenreNotFoundException extends Exception
{
    public function __construct($genre)
    {
        parent::__construct("Genre ". $genre ." was not found", 404);
    }
}