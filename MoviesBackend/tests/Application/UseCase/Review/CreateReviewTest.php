<?php

namespace App\Tests\Application\UseCase\Review;

use DateTime;
use App\Domain\Model\UserModel;
use PHPUnit\Framework\TestCase;
use App\Domain\Model\MoviesModel;
use App\Domain\Model\ReviewModel;
use App\Application\Repository\MoviesRepository;
use App\Application\Repository\ReviewRepository;
use App\Domain\Exception\MovieNotFoundException;
use App\Application\UseCases\Review\CreateReview;

class CreateReviewTest extends TestCase
{
    private MoviesRepository $moviesRepository;
    private ReviewRepository $reviewRepository;
    private CreateReview $createReview;

    public function setUp(): void
    {
        $this->reviewRepository = $this->createMock(ReviewRepository::class);
        $this->moviesRepository = $this->createMock(MoviesRepository::class);
        $this->createReview = new CreateReview($this->moviesRepository, $this->reviewRepository);
    }

    public function testCreateReviewCorrectly(): void
    {
        $review = json_decode('{
            "title": "titleExample",
            "paragraph":"ExampleExample",
            "score": 2.1,
            "movieId": 1
        }');

        $movieFound = new MoviesModel('example', 'example', new DateTime('2021-02-02'), 3600, 1);
        $userModel = new UserModel('alex', 'alex@gmail.com',['ROLE_USER'],1);
        $reviewModel = new ReviewModel($review->title, $review->paragraph, new DateTime(), $review->score, $movieFound, $userModel);
        
        $this->moviesRepository->expects($this->once())
            ->method('findById')
            ->with($review->movieId)
            ->willReturn($movieFound);
        
        $this->reviewRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(ReviewModel::class));

        $this->createReview->handle($review, $userModel);
    }

    public function testCreateReviewWhenIdMovieDoesntExist(): void
    {
        $review = json_decode('{
            "title": "titleExample",
            "paragraph":"ExampleExample",
            "score": 2.1,
            "movieId": 1
        }');

        $userModel = new UserModel('alex', 'alex@gmail.com',['ROLE_USER'],1);

        $this->moviesRepository->expects($this->once())
            ->method('findById')
            ->with($review->movieId);
        
        $this->reviewRepository->expects($this->never())
            ->method('save')
            ->with($this->isInstanceOf(ReviewModel::class));

        $this->expectException(MovieNotFoundException::class);

        $this->createReview->handle($review, $userModel);
    }
}