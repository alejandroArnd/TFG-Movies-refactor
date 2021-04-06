<?php

namespace App\Application\Dto\Response\Transformer;

use App\Application\Dto\Response\MovieResponseDto;

class MovieResponseDtoTransformer extends ResponseDtoTransformer
{
    private GenreResponseDtoTransformer $genreResponseDtoTransformer;

    public function __construct(GenreResponseDtoTransformer $genreResponseDtoTransformer) {
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
        $dto->setAccessiblePath($movie->getAccessiblePath());
        $dto->setGenres($this->genreResponseDtoTransformer->transformFromObjects($movie->getGenres()));
        $dto->setCountReviews(count($movie->getReviews()));
        $dto->setAverageScore($this->calculateAverageScore($movie->getReviews()));

        return $dto;
    }

    private function calculateAverageScore(array $reviews): float
    {
        $averageScore = 0;

        foreach($reviews as $review){
            $averageScore += $review->getScore();
        }
        $averageScore = empty($averageScore) ? 0 : round($averageScore / count($reviews), 1);
        return $averageScore;
    }
}