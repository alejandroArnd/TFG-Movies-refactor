<?php

namespace App\Application\Repository;

use App\Domain\Entity\Movies;
interface MoviesRepository
{
    public function save(Movies $movies): void;
    
    public function getAll():array;
}