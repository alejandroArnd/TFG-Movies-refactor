<?php

namespace App\Application\UseCases\Movies;

use App\Application\Repository\MoviesRepository;
use App\Domain\Exception\MovieNotFoundException;

class SoftDeleteMovie
{
    private MoviesRepository $moviesRepository;

    public function __construct(MoviesRepository $moviesRepository)
    {
        $this->moviesRepository = $moviesRepository;
    }

    public function handle(int $id): void
    {
        $movie = $this->moviesRepository->findById($id);

        if(!$movie){
            throw new MovieNotFoundException();
        }

        $movie->setIsDeleted(true);
        $this->moviesRepository->save($movie);
    }
}