<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\ReviewModel;
use App\Infrastructure\Entity\Review;
use App\Application\Repository\MoviesRepository;

class ReviewMapper extends AbstractDataMapper
{
    private MoviesRepository $moviesRepository;

    public function __construct(MoviesRepository $moviesRepository)
    {
        $this->moviesRepository = $moviesRepository;
    }

    public function toEntity(ReviewModel $reviewModel): ?Review
    {
        $movieEntity = $this->moviesRepository->find($reviewModel->getMovies()->getId());
        $review = new Review(
            $reviewModel->getTitle(), 
            $reviewModel->getParagraph(), 
            $reviewModel->getPostingDate(), 
            $reviewModel->getScore(),
            $movieEntity
        );

        return $review;
    }
    public function toModel(Review $reviewEntity): ?ReviewModel
    {
        $movieModel = $this->moviesRepository->findById($reviewEntity->getMovies()->getId());
        $review = new ReviewModel(
            $reviewEntity->getTitle(), 
            $reviewEntity->getParagraph(), 
            $reviewEntity->getPostingDate(), 
            $reviewEntity->getScore(),
            $movieModel,
            $reviewEntity->getId()
        );

        return $review;
    }
}