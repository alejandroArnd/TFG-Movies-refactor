<?php

namespace App\Applocation\Dto\Response;

class MovieResponseDto
{
    public int $id;

    public string $title;

    public string $overview;

    public string $releaseDate;

    public int $duration;

    public bool $isDeleted;

    public array $genres;

    public array $reviews;

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
        return $this->genre;
    }

    public function setGenres($genre): void
    {
        $this->genre = $genre;
    }

    public function getReviews(): array
    {
        return $this->reviews;
    }

    public function setReviews($reviews): void
    {
        $this->reviews = $reviews;
    }
}