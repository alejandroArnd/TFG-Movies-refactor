<?php

namespace App\Application\Dto\Response\Transformer;

use App\Application\Dto\Response\MovieSearchResponseDto;

class MovieSearchResponseDtoTransformer extends ResponseDtoTransformer
{
    public function transformFromObject($movie): MovieSearchResponseDto
    {
        $dto = new MovieSearchResponseDto();
        $dto->setId($movie->movie->getId());
        $dto->setTitle($movie->movie->getTitle());
        $dto->setAccessiblePath($movie->movie->getAccessiblePath());
        $dto->setAvarageScore($movie->averageScore);

        return $dto;
    }
}