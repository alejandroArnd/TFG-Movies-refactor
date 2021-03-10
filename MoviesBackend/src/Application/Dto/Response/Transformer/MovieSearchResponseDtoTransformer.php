<?php

namespace App\Application\Dto\Response\Transformer;

use App\Application\Dto\Response\MovieSearchResponseDto;

class MovieSearchResponseDtoTransformer extends ResponseDtoTransformer
{
    public function transformFromObject($movie): MovieSearchResponseDto
    {
        $dto = new MovieSearchResponseDto();
        $dto->setId($movie->getId());
        $dto->setTitle($movie->getTitle());
        $dto->setAccessiblePath($movie->getAccessiblePath());

        return $dto;
    }
}