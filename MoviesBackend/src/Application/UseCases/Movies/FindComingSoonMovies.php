<?php

namespace App\Application\UseCases\Movies;

use App\Application\Repository\MoviesRepository;
use App\Application\Dto\Response\Transformer\MovieSearchResponseDtoTransformer;

class FindComingSoonMovies
{
    private MoviesRepository $moviesRepository;
    private MovieSearchResponseDtoTransformer $movieResponseDtoTransformer;

    public function __construct(MoviesRepository $moviesRepository, MovieSearchResponseDtoTransformer $movieResponseDtoTransformer)
    {
        $this->moviesRepository = $moviesRepository;
        $this->movieResponseDtoTransformer = $movieResponseDtoTransformer;
    }

    public function handle(): array
    {
        $movies = $this->moviesRepository->findComingSoonMovies();
        return $this->movieResponseDtoTransformer->transformFromObjects($movies);
    }
}