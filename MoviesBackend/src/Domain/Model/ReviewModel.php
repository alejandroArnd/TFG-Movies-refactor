<?php

namespace App\Domain\Model;

use DateTime;
use App\Domain\Model\MoviesModel;

class ReviewModel
{
    private $id;
    private $title;
    private $paragraph;
    private $score;
    private $postingDate;
    private $movies;

    public function __construct(string $title, string $paragraph, DateTime $postingDate, float $score, MoviesModel $movies, int $id = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->paragraph = $paragraph;
        $this->postingDate = $postingDate;
        $this->score = $score;
        $this->movies = $movies;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getParagraph(): ?string
    {
        return $this->paragraph;
    }

    public function setParagraph(string $paragraph): void
    {
        $this->paragraph = $paragraph;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(float $score): void
    {
        $this->score = $score;
    }

    public function getPostingDate(): ?DateTime
    {
        return $this->postingDate;
    }

    public function setPostingDate(DateTime $postingDate): void
    {
        $this->postingDate = $postingDate;
    }

    public function getMovies(): ?MoviesModel
    {
        return $this->movies;
    }

    public function setMovies(?MoviesModel $movies): void
    {
        $this->movies = $movies;
    }
}
