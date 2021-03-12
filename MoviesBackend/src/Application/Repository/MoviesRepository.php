<?php

namespace App\Application\Repository;

use App\Domain\Model\MoviesModel;

interface MoviesRepository
{
    public function save(MoviesModel $movie): void;
    
    public function getAll(): array;

    public function findById(int $id): ?MoviesModel;

    public function findOneByTitle(string $title): ?MoviesModel;

    public function findMoviesBySeveralCriterias(object $criteriaParams): object;
}
