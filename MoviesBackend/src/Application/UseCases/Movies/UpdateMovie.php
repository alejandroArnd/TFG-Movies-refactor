<?php

namespace App\Application\UseCases\Movies;

use DateTime;
use App\Application\Repository\MoviesRepository;
use App\Domain\Exception\MovieNotFoundException;
use App\Domain\Exception\MovieAlreadyExistException;

class UpdateMovie
{
    private MoviesRepository $moviesRepository;

    public function __construct(MoviesRepository $moviesRepository)
    {
        $this->moviesRepository = $moviesRepository;
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

        $movieFound->setTitle($movie->title);
        $movieFound->setOverview($movie->overview);
        $movieFound->setReleaseDate(new DateTime($movie->releaseDate));
        $movieFound->setDuration($movie->duration);

        $this->moviesRepository->save($movieFound);

    }
}