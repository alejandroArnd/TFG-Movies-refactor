<?php

namespace App\Application\Dto\Response\Transformer;

use App\Applocation\Dto\Response\GenreResponseDto;

class GenreResponseDtoTransformer extends ResponseDtoTransformer
{
    public function transformFromObject($genre): GenreResponseDto
    {
        $dto = new GenreResponseDto();
        $dto->setName($genre->getName());

        return $dto;
    }
}