<?php

namespace App\Application\Dto\Response\Transformer;

use App\Applocation\Dto\Response\UserResponseDto;

class UserResponseDtoTransformer extends ResponseDtoTransformer
{
    public function transformFromObject($user): UserResponseDto
    {
        $dto = new UserResponseDto();
        $dto->setUsername($user->getUsername());

        return $dto;
    }
}