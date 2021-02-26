<?php

namespace App\Application\UseCases\Review;

use DateTime;
use App\Domain\Model\ReviewModel;
use App\Application\Repository\MoviesRepository;
use App\Application\Repository\ReviewRepository;
use App\Domain\Exception\MovieNotFoundException;

class CreateReview
{
    private MoviesRepository $moviesRepository;
    private ReviewRepository $reviewRepository;

    public function __construct(MoviesRepository $moviesRepository, ReviewRepository $reviewRepository)
    {
        $this->moviesRepository = $moviesRepository;
        $this->reviewRepository = $reviewRepository;
    }

    public function handle($review): void
    {
        $movieFound = $this->moviesRepository->findById($review->movieId);

        if(!$movieFound){
            throw new MovieNotFoundException();
        }

        $review = new ReviewModel($review->title, $review->paragraph, new DateTime(), $review->score, $movieFound);

        $this->reviewRepository->save($review);

    }
}