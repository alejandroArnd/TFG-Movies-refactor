<?php

namespace App\Domain\Exception;

use Exception;

class GenreNotFoundException extends Exception
{
    private string $genre; 

    public function __construct($genre)
    {
        $this->genre = $genre;
    }
    public function errorMessage()
    {
        return ["message" => "Genre ". $this->genre ." was not found", "status" => 404];
    }
}