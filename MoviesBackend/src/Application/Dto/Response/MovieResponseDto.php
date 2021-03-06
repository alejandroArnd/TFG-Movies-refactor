<?php

namespace App\Application\Dto\Response;

class MovieResponseDto
{
    public int $id;

    public string $title;

    public string $overview;

    public string $releaseDate;

    public int $duration;

    public bool $isDeleted;

    public string $accessiblePath;

    public array $genres;

    public int $countReviews;

    public float $averageScore;

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

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function setOverview($overview): void
    {
        $this->overview = $overview;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function setReleaseDate($releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration($duration): void
    {
        $this->duration = $duration;
    }

    public function getIsDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted($isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function setGenres($genres): void
    {
        $this->genres = $genres;
    }

    public function getCountReviews(): int
    {
        return $this->countReviews;
    }

    public function setCountReviews($countReviews): void
    {
        $this->countReviews = $countReviews;
    }

    public function getAccessiblePath(): string
    {
        return $this->accessiblePath;
    }

    public function setAccessiblePath($accessiblePath): void
    {
        $this->accessiblePath = $accessiblePath;
    }

    public function getAverageScore(): float
    {
        return $this->averageScore;
    }

    public function setAverageScore($averageScore): void
    {
        $this->averageScore = $averageScore;
    }
}