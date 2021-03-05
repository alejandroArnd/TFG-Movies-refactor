<?php

namespace App\Application\UseCases\Movies;

use DateTime;
use App\Application\Repository\GenreRepository;
use App\Application\Repository\MoviesRepository;
use App\Domain\Exception\GenreNotFoundException;
use App\Domain\Exception\MovieNotFoundException;
use App\Domain\Exception\MovieAlreadyExistException;

class UpdateMovie
{
    private MoviesRepository $moviesRepository;
    private GenreRepository $genreRepository;

    public function __construct(MoviesRepository $moviesRepository, GenreRepository $genreRepository)
    {
        $this->moviesRepository = $moviesRepository;
        $this->genreRepository = $genreRepository;
    }

    public function handle($movie): void
    {
        $movieFound = $this->moviesRepository->findById($movie->id);

        if(!$movieFound){
            throw new MovieNotFoundException();
        }

        $movieAlreadyExit = $this->moviesRepository->findOneByTitle($movie->title);

        if($movieAlreadyExit && $movieAlreadyExit->getId() !== $movie->id){
            throw new MovieAlreadyExistException();
        }

        $genres = [];

        foreach($movieFound->getGenres() as $genre){
            $movieFound->removeGenre($genre);
        }

        foreach($movie->genres as $genre){
            $genreFound = $this->genreRepository->findOneByName($genre);
            
            if(!$genreFound){
                throw new GenreNotFoundException($genre);
            }

            $movieFound->addGenre($genreFound);
        }

        $movieFound->setTitle($movie->title);
        $movieFound->setOverview($movie->overview);
        $movieFound->setReleaseDate(new DateTime($movie->releaseDate));
        $movieFound->setDuration($movie->duration);

        $this->moviesRepository->save($movieFound);

    }
}