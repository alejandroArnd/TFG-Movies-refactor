<?php

namespace App\Application\Dto\Response\Transformer;

use App\Application\Dto\Response\MovieResponseDto;

class MovieResponseDtoTransformer extends ResponseDtoTransformer
{
    private GenreResponseDtoTransformer $genreResponseDtoTransformer;
    private ReviewResponseDtoTransformer $reviewResponseDtoTransformer;

    public function __construct(
        GenreResponseDtoTransformer $genreResponseDtoTransformer,
        ReviewResponseDtoTransformer $reviewResponseDtoTransformer
    ) {
        $this->genreResponseDtoTransformer = $genreResponseDtoTransformer;
        $this->reviewResponseDtoTransformer = $reviewResponseDtoTransformer;
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
        $dto->setReviews($this->reviewResponseDtoTransformer->transformFromObjects($movie->getReviews()));

        return $dto;
    }
}