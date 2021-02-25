<?php

namespace App\Application\Dto\Response\Transformer;

use App\Applocation\Dto\Response\MovieSearchResponseDto;

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
        $dto->setId($movie->getId());
        $dto->setTitle($movie->getTitle());

        return $dto;
    }
}