<?php

namespace App\Application\Dto\Response\Transformer;

use App\Applocation\Dto\Response\MovieResponseDto;

class MovieResponseDtoTransformer extends ResponseDtoTransformer
{
    private GenreResponseDtoTransformer $genreResponseDtoTransformer;

    public function __construct(GenreResponseDtoTransformer $genreResponseDtoTransformer)
    {
        $this->genreResponseDtoTransformer = $genreResponseDtoTransformer;
    }

    public function transformFromObject($movie): MovieResponseDto
    {
        $dto = new MovieResponseDto();
        $dto->setId($movie->getId());
        $dto->setTitle($movie->getTitle());
        $dto->setOverview($movie->getOverview());
        $dto->setReleaseDate($movie->getReleaseDate()->format('Y-m-d'),);
        $dto->setDuration($movie->getDuration());
        $dto->setIsDeleted($movie->getIsDeleted());
        $dto->setGenres($this->genreResponseDtoTransformer->transformFromObjects($movie->getGenres()));

        return $dto;
    }
}