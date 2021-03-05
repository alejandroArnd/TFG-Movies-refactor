<?php

namespace App\Application\Dto\Response\Transformer;

use App\Application\Dto\Response\ReviewResponseDto;

class ReviewResponseDtoTransformer extends ResponseDtoTransformer
{
    private UserResponseDtoTransformer $userResponseDtoTransformer;

    public function __construct(UserResponseDtoTransformer $userResponseDtoTransformer)
    {
        $this->userResponseDtoTransformer = $userResponseDtoTransformer;
    }

    public function transformFromObject($review): ReviewResponseDto
    {
        $dto = new ReviewResponseDto();
        $dto->setTitle($review->getTitle());
        $dto->setParagraph($review->getParagraph());
        $dto->setPostingDate($review->getPostingDate()->format('Y-m-d'),);
        $dto->setScore($review->getScore());
        $dto->setUser($this->userResponseDtoTransformer->transformFromObject($review->getUser()));

        return $dto;
    }
}