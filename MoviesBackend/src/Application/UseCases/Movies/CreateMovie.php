<?php

namespace App\Application\UseCases\Movies;

use DateTime;
use App\Domain\Entity\Movies;
use App\Application\Repository\MoviesRepository;
use App\Domain\Exception\MovieAlreadyExistException;

class CreateMovie
{
    private MoviesRepository $moviesRepository;

    public function __construct(MoviesRepository $moviesRepository)
    {
        $this->moviesRepository = $moviesRepository;
    }

    public function handle($movie): void
    {
        $movieAlreadyExit = $this->moviesRepository->findOneByTitle($movie->title);

        if($movieAlreadyExit){
            throw new MovieAlreadyExistException();
        }

        $movie = new Movies($movie->title, $movie->overview, new DateTime($movie->releaseDate), $movie->duration);
        $this->moviesRepository->save($movie);
    }
}