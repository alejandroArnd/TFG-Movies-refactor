<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\GenreModel;
use App\Infrastructure\Entity\Genre;

class GenreMapper extends AbstractDataMapper
{
    public function toModel(Genre $genreEntity): ?GenreModel
    {
        return new GenreModel($genreEntity->getName(), $genreEntity->getId());
    }
}