<?php

namespace App\Application\UseCases\Movies;

use App\Application\Repository\MoviesRepository;

class FindMoviesByTitle
{
    private MoviesRepository $moviesRepository;

    public function __construct(MoviesRepository $moviesRepository)
    {
        $this->moviesRepository = $moviesRepository;
    }

    public function handle(string $title): array
    {
        $movies = $this->moviesRepository->findByTitle($title);
        foreach($movies as $movie){
            $moviesJson[] = [
               'id' => $movie->getId(), 
               'title' => $movie->getTitle(), 
            ];
        }
        return $moviesJson;
    }
}