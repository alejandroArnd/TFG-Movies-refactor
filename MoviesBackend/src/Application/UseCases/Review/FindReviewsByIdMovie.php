<?php

namespace App\Application\UseCases\Review;

use App\Application\Repository\ReviewRepository;
use App\Application\Dto\Response\Transformer\ReviewResponseDtoTransformer;

class FindReviewsByIdMovie
{
    private ReviewRepository $reviewRepository;
    private ReviewResponseDtoTransformer $reviewResponseDtoTransformer;

    public function __construct(ReviewRepository $reviewRepository, ReviewResponseDtoTransformer $reviewResponseDtoTransformer)
    {
        $this->reviewRepository = $reviewRepository;
        $this->reviewResponseDtoTransformer = $reviewResponseDtoTransformer;
    }
    public function handle(int $movieId): array
    {
        $reviews = $this->reviewRepository->findByIdMovie($movieId);
        $reviewsJson = $this->reviewResponseDtoTransformer->transformFromObjects($reviews);
        return $reviewsJson;
    }
}