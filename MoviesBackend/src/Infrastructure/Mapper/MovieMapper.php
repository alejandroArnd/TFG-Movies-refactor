<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\MoviesModel;
use App\Infrastructure\Entity\Movies;
use App\Infrastructure\Mapper\GenreMapper;
use App\Application\Repository\GenreRepository;

class MovieMapper extends AbstractDataMapper
{
    private GenreRepository $genreRepository;
    private GenreMapper $genreMapper;

    public function __construct(GenreRepository $genreRepository, GenreMapper $genreMapper)
    {
        $this->genreRepository = $genreRepository;
        $this->genreMapper = $genreMapper;
    }

    public function toEntity(MoviesModel $movieModel): ?Movies
    {
        $genres = $movieModel->getGenres();
        $genresEntities = $this->toArrayEntityGenre($genres);
        $movie = new Movies(
            $movieModel->getTitle(), 
            $movieModel->getOverview(), 
            $movieModel->getReleaseDate(), 
            $movieModel->getDuration(), 
        );

        foreach($genresEntities as $genre){
            $movie->addGenre($genre);
        }
        return $movie;
    }
    public function toModel(Movies $movieEntity): ?MoviesModel
    {
        $movieModel = new MoviesModel(
            $movieEntity->getTitle(), 
            $movieEntity->getOverview(), 
            $movieEntity->getReleaseDate(), 
            $movieEntity->getDuration(),
            $movieEntity->getId(),
            $movieEntity->getIsDeleted() 
        );

        $genreModels = $this->genreMapper->toArrayModel($movieEntity->getGenres()->toArray());
        
        foreach($genreModels as $genre){
            $movieModel->addGenre($genre);
        }

        return $movieModel;
    }

    private function toArrayEntityGenre(array $models): array
    {
        $entities = [];

        foreach($models as $model){
            $entities[] = $this->genreRepository->findOneByName($model->getName(), true);
        }
        
        return $entities;
    }
}