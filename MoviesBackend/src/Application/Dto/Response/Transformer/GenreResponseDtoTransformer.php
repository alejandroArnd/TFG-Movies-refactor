<?php

namespace App\Application\Dto\Response\Transformer;

use App\Application\Dto\Response\GenreResponseDto;

class GenreResponseDtoTransformer extends ResponseDtoTransformer
{
    public function transformFromObject($genre): GenreResponseDto
    {
        $dto = new GenreResponseDto();
        $dto->setId($genre->getId());
        $dto->setName($genre->getName());

        return $dto;
    }
}