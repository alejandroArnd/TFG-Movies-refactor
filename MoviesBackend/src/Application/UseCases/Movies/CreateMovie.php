<?php

namespace App\Application\UseCases\Movies;

use DateTime;
use App\Domain\Model\MoviesModel;
use App\Application\Repository\GenreRepository;
use App\Application\Repository\MoviesRepository;
use App\Domain\Exception\GenreNotFoundException;
use App\Domain\Exception\MovieAlreadyExistException;

class CreateMovie
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
        $movieAlreadyExit = $this->moviesRepository->findOneByTitle($movie->title);

        if($movieAlreadyExit){
            throw new MovieAlreadyExistException();
        }

        $genres = [];

        $newMovie = new MoviesModel($movie->title, $movie->overview, new DateTime($movie->releaseDate), $movie->duration);

        foreach($movie->genres as $genre){
            $genreFound = $this->genreRepository->findOneByName($genre);
            
            if(!$genreFound){
                throw new GenreNotFoundException($genre);
            }

            $newMovie->addGenre($genreFound);
        }

        $this->moviesRepository->save($newMovie);
    }
}