<?php

namespace App\Tests\Application\UseCase\Review;

use DateTime;
use App\Domain\Model\UserModel;
use PHPUnit\Framework\TestCase;
use App\Domain\Model\MoviesModel;
use App\Domain\Model\ReviewModel;
use App\Application\Repository\ReviewRepository;
use App\Application\Dto\Response\UserResponseDto;
use App\Application\Dto\Response\ReviewResponseDto;
use App\Application\UseCases\Review\FindReviewsByIdMovie;
use App\Application\Dto\Response\Transformer\UserResponseDtoTransformer;
use App\Application\Dto\Response\Transformer\ReviewResponseDtoTransformer;

class FindReviewsByIdMovieTest extends TestCase
{
    private ReviewRepository $reviewRepository;
    private ReviewResponseDtoTransformer $reviewResponseDtoTransformer;
    private UserResponseDtoTransformer $userResponseDtoTransformer;
    private FindReviewsByIdMovie $findReviewsByIdMovie;

    public function setUp(): void
    {
        $this->userResponseDtoTransformer = $this->getMockBuilder(UserResponseDtoTransformer::class)
                                                  ->enableProxyingToOriginalMethods()
                                                  ->enableOriginalConstructor()
                                                  ->getMock();
        $this->reviewResponseDtoTransformer = $this->getMockBuilder(ReviewResponseDtoTransformer::class)
                                                  ->enableProxyingToOriginalMethods()
                                                  ->enableOriginalConstructor()
                                                  ->setConstructorArgs([$this->userResponseDtoTransformer])
                                                  ->getMock();
        $this->reviewRepository = $this->createMock(ReviewRepository::class);
        $this->findReviewsByIdMovie = new FindReviewsByIdMovie($this->reviewRepository, $this->reviewResponseDtoTransformer);
    }

    public function testFindReviewsByIdMovieCorrectly(): void
    {
        $reviewModel = $this->getAllReviewModelDataProvider();

        $reviewDtosExpected = $this->getAllReviewDtosDataProvider();
        
        $this->reviewRepository->expects($this->once())
            ->method('findByIdMovie')
            ->with(1)
            ->willReturn($reviewModel);
        
        $this->reviewResponseDtoTransformer->expects($this->once())
            ->method('transformFromObjects')
            ->with($reviewModel);
        
        $reviewReturned = $this->findReviewsByIdMovie->handle(1);

        $this->assertEquals($reviewDtosExpected, $reviewReturned);
    }

    public function getAllReviewModelDataProvider()
    {

        $userModel = new UserModel('alex', 'alex@gmail.com',['ROLE_USER'],1);

        $movieFound = new MoviesModel('example', 'example', new DateTime('2021-02-02'), 3600, 1);
        $reviewModelFirst = new ReviewModel('example1', 'example1', new DateTime('2021-02-12'), 2.1, $movieFound, $userModel, 1);

        $reviewModelSecond = new ReviewModel('example2', 'example2', new DateTime('2021-02-08'), 5.0, $movieFound, $userModel, 2);

        return  [$reviewModelFirst, $reviewModelSecond];
    }


    public function getAllReviewDtosDataProvider()
    {
        $userDto = new UserResponseDto();
        $userDto->setUsername('alex');

        $postingDateFirst = new DateTime('2021-02-12');
        $reviewDtoFirst = new ReviewResponseDto();
        $reviewDtoFirst->setTitle('example1');
        $reviewDtoFirst->setParagraph('example1');
        $reviewDtoFirst->setPostingDate($postingDateFirst->format('Y-m-d'));
        $reviewDtoFirst->setScore(2.1);
        $reviewDtoFirst->setUser($userDto);

        $postingDateSecond = new DateTime('2021-02-08');
        $reviewDtoSecond = new ReviewResponseDto();
        $reviewDtoSecond->setTitle('example2');
        $reviewDtoSecond->setParagraph('example2');
        $reviewDtoSecond->setPostingDate($postingDateSecond->format('Y-m-d'));
        $reviewDtoSecond->setScore(5.0);
        $reviewDtoSecond->setUser($userDto);

        return  [$reviewDtoFirst, $reviewDtoSecond];
    }
}