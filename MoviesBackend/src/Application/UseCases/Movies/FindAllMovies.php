<?php

namespace App\Application\UseCases\Movies;

use App\Application\Repository\MoviesRepository;

class FindAllMovies
{
    private MoviesRepository $moviesRepository;

    public function __construct(MoviesRepository $moviesRepository)
    {
        $this->moviesRepository = $moviesRepository;
    }

    public function handle(): array
    {
        $moviesJson;
        $movies = $this->moviesRepository->getAll();
        foreach($movies as $movie){
            $moviesJson[] = [
                $movie->getId(), 
                $movie->getTitle(), 
                $movie->getOverview(), 
                $movie->getReleaseDate()->format('Y-m-d'), 
                $movie->getDuration()->format('H:i:s')
            ];
        }
        return $moviesJson;
    }
}