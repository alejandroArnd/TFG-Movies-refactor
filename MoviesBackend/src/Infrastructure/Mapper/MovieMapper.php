<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\MoviesModel;
use App\Infrastructure\Entity\Movies;

class MovieMapper extends AbstractDataMapper
{
    public function toEntity(MoviesModel $movieModel): ?Movies
    {
        return new Movies(
            $movieModel->getTitle(), 
            $movieModel->getOverview(), 
            $movieModel->getReleaseDate(), 
            $movieModel->getDuration(), 
        );
    }
    public function toModel(Movies $movieEntity): ?MoviesModel
    {
        return new MoviesModel(
            $movieEntity->getTitle(), 
            $movieEntity->getOverview(), 
            $movieEntity->getReleaseDate(), 
            $movieEntity->getDuration(),
            $movieEntity->getId(),
            $movieEntity->getIsDeleted() 
        );
    }
}