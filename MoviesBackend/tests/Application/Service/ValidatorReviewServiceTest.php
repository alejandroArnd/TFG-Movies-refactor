<?php

namespace App\Tests\Application\Service;

use PHPUnit\Framework\TestCase;
use App\Domain\Exception\TitleLengthException;
use App\Domain\Exception\ParagraphLengthException;
use App\Application\Service\ValidatorReviewService;
use App\Domain\Exception\ScoreIsNotValidNumberException;

class ValidatorReviewServiceTest extends TestCase
{
    private ValidatorReviewService $validatorReview;

    public function setUp(): void
    {
        $this->validatorReview = new ValidatorReviewService();
    }

    public function testvalidateReviewWhenScoreIsNotValidNumber(): void
    {
        $review = json_decode('{
            "title": "titleExample",
            "paragraph":"ExampleExample",
            "score": "-sa21.1",
            "movieId": 1
        }');

        $this->expectException(ScoreIsNotValidNumberException::class);

        $this->validatorReview->validate($review);
    }

    public function testvalidateReviewWhenParagraphHasMore1000Characters(): void
    {
        $review = json_decode('{
            "title": "titleExample",
            "paragraph":"ExampleExample",
            "score": 2.1,
            "movieId": 1
        }');

        $review->paragraph = $this->setMoreCharacters($review->paragraph);
        $this->expectException(ParagraphLengthException::class);

        $this->validatorReview->validate($review);
    }

    public function testvalidateReviewWhenTitleHasMore255Characters(): void
    {
        $review = json_decode('{
            "title": "title",
            "paragraph":"ExampleExample",
            "score": 2.1,
            "movieId": 1
        }');

        $review->title = $this->setMoreCharacters($review->title);
        $this->expectException(TitleLengthException::class);

        $this->validatorReview->validate($review);
    }

    private function setMoreCharacters($stringToSetMoreCharacters)
    {
        for($i = 1; $i <= 15; $i++){
            $stringToSetMoreCharacters .= $stringToSetMoreCharacters;
        }
        return $stringToSetMoreCharacters;
    }
}