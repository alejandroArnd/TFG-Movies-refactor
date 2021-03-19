<?php

namespace App\Application\Dto\Response;

class MovieSearchResponseDto
{
    public int $id;

    public string $title;

    public string $accessiblePath;

    public float $avarageScore;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getAccessiblePath(): string
    {
        return $this->accessiblePath;
    }
 
    public function setAccessiblePath($accessiblePath): void
    {
        $this->accessiblePath = $accessiblePath;
    }

    public function getAvarageScore(): float
    {
        return $this->avarageScore;
    }

    public function setAvarageScore($avarageScore): void
    {
        $this->avarageScore = $avarageScore;
    }
}