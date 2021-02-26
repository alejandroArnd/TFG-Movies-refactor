<?php

namespace App\Application\Dto\Response\Transformer;

use App\Applocation\Dto\Response\ReviewResponseDto;

class ReviewResponseDtoTransformer extends ResponseDtoTransformer
{
    public function transformFromObject($review): ReviewResponseDto
    {
        $dto = new ReviewResponseDto();
        $dto->setTitle($review->getTitle());
        $dto->setParagraph($review->getParagraph());
        $dto->setPostingDate($review->getPostingDate()->format('Y-m-d'),);
        $dto->setScore($review->getScore());

        return $dto;
    }
}