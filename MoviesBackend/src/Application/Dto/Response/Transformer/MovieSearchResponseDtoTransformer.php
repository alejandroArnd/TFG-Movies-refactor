<?php

namespace App\Application\Dto\Response\Transformer;

use App\Application\Dto\Response\MovieSearchResponseDto;
use App\Application\Dto\Response\Transformer\GenreResponseDtoTransformer;

class MovieSearchResponseDtoTransformer extends ResponseDtoTransformer
{
    private GenreResponseDtoTransformer $genreResponseDtoTransformer;

    public function __construct(GenreResponseDtoTransformer $genreResponseDtoTransformer) 
    {
        $this->genreResponseDtoTransformer = $genreResponseDtoTransformer;
    }

    public function transformFromObject($movie): MovieSearchResponseDto
    {
        $dto = new MovieSearchResponseDto();
        $dto->setId($movie->movie->getId());
        $dto->setTitle($movie->movie->getTitle());
        $dto->setAccessiblePath($movie->movie->getAccessiblePath());
        $dto->setAverageScore($movie->averageScore);
        $dto->setReleaseDate($movie->movie->getReleaseDate()->format('d-m-Y'));
        $dto->setGenres($this->genreResponseDtoTransformer->transformFromObjects($movie->movie->getGenres()));

        return $dto;
    }
}