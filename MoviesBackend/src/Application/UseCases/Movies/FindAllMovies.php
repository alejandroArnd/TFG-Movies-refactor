<?php

namespace App\Application\UseCases\Movies;

use App\Application\Repository\MoviesRepository;
use App\Application\Dto\Response\Transformer\MovieResponseDtoTransformer;

class FindAllMovies
{
    private MoviesRepository $moviesRepository;
    private MovieResponseDtoTransformer $movieResponseDtoTransformer;

    public function __construct(MoviesRepository $moviesRepository, MovieResponseDtoTransformer $movieResponseDtoTransformer)
    {
        $this->moviesRepository = $moviesRepository;
        $this->movieResponseDtoTransformer = $movieResponseDtoTransformer;
    }

    public function handle(): array
    {
        $movies = $this->moviesRepository->getAll();
        $moviesJson = $this->movieResponseDtoTransformer->transformFromObjects($movies);
        return $moviesJson;
    }
}