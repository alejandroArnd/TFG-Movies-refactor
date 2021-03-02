<?php

namespace App\Applocation\Dto\Response;

class ReviewResponseDto
{
    public string $title;

    public string $paragraph;

    public string $postingDate;

    public float $score;

    public UserResponseDto $user;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getParagraph(): string
    {
        return $this->paragraph;
    }

    public function setParagraph($paragraph): void
    {
        $this->paragraph = $paragraph;
    }

    public function getPostingDate(): string
    {
        return $this->postingDate;
    }

    public function setPostingDate($postingDate): void
    {
        $this->postingDate = $postingDate;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    public function setScore($score): void
    {
        $this->score = $score;
    }

    public function getUser(): UserResponseDto
    {
        return $this->user;
    }

    public function setUser(UserResponseDto $user): void
    {
        $this->user = $user;
    }

}