<?php

namespace App\Application\Repository;

use App\Domain\Model\GenreModel;

interface GenreRepository
{
    public function findOneByName(string $name): ?object;
}