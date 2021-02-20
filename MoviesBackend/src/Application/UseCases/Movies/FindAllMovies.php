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
               'id' => $movie->getId(), 
               'title' => $movie->getTitle(), 
               'overview' => $movie->getOverview(), 
               'releaseDate' => $movie->getReleaseDate()->format('Y-m-d'), 
               'duration' => $movie->getDuration(),
               'isDeleted' => $movie->getIsDeleted()
            ];
        }
        return $moviesJson;
    }
}