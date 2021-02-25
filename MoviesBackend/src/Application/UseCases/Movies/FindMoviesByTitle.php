<?php

namespace App\Application\UseCases\Movies;

use App\Application\Repository\MoviesRepository;
use App\Application\Dto\Response\Transformer\MovieSearchResponseDtoTransformer;

class FindMoviesByTitle
{
    private MoviesRepository $moviesRepository;
    private MovieSearchResponseDtoTransformer $movieSearchResponseDtoTransformer;

    public function __construct(MoviesRepository $moviesRepository, MovieSearchResponseDtoTransformer $movieSearchResponseDtoTransformer)
    {
        $this->moviesRepository = $moviesRepository;
        $this->movieSearchResponseDtoTransformer = $movieSearchResponseDtoTransformer;
    }
    public function handle(string $title): array
    {
        $movies = $this->moviesRepository->findByTitle($title);
        $moviesJson = $this->movieSearchResponseDtoTransformer->transformFromObjects($movies);
        return $moviesJson;
    }
}