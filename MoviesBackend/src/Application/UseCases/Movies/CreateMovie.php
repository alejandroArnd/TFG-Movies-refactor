<?php

namespace App\Application\UseCases\Movies;

use App\Domain\Entity\Movies;
use App\Application\Repository\MoviesRepository;
use DateTime;

class CreateMovie
{
    private MoviesRepository $moviesRepository;

    public function __construct(MoviesRepository $moviesRepository)
    {
        $this->moviesRepository = $moviesRepository;
    }

    public function handle($movie): void
    {
        $movie = new Movies($movie->title, $movie->overview, new DateTime($movie->releaseDate), new DateTime($movie->duration));
        $this->moviesRepository->save($movie);
    }
}