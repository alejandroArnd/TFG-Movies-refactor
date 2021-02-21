<?php

namespace App\Application\Repository;

use App\Domain\Entity\Movies;
interface MoviesRepository
{
    public function save(Movies $movies): void;
    
    public function getAll(): array;

    public function findById(int $id): ?Movies;

    public function findOneByTitle(string $title): ?Movies;

    public function findByTitle(string $title): array;
}
