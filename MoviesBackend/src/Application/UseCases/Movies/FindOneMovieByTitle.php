<?php

namespace App\Application\UseCases\Movies;

use App\Application\Repository\MoviesRepository;
use App\Domain\Exception\MovieNotFoundException;
use App\Applocation\Dto\Response\MovieResponseDto;
use App\Application\Dto\Response\Transformer\MovieResponseDtoTransformer;

class FindOneMovieByTitle
{
    private MoviesRepository $moviesRepository;
    private MovieResponseDtoTransformer $movieResponseDtoTransformer;

    public function __construct(MoviesRepository $moviesRepository, MovieResponseDtoTransformer $movieResponseDtoTransformer)
    {
        $this->moviesRepository = $moviesRepository;
        $this->movieResponseDtoTransformer = $movieResponseDtoTransformer;
    }
    public function handle(string $title): MovieResponseDto
    {
        $movie = $this->moviesRepository->findOneByTitle($title);
        if(!$movie){
            throw new MovieNotFoundException();
        }

        $movieJson = $this->movieResponseDtoTransformer->transformFromObject($movie);
        return $movieJson;
    }
}