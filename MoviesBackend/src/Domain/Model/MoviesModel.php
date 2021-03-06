<?php

namespace App\Domain\Model;

use DateTime;
use App\Domain\Model\GenreModel;
use App\Domain\Model\ReviewModel;

class MoviesModel
{

    private $id;
    private $title;
    private $overview;
    private $releaseDate;
    private $duration;
    private $isDeleted;
    private $accessiblePath;
    private $genres;
    private $reviews;

    public function __construct(string $title, string $overview, DateTime $releaseDate, int $duration, string $accessiblePath = null, int $id = null, bool $isDeleted = false)
    {
        $this->id = $id;
        $this->title = $title;
        $this->overview = $overview;
        $this->releaseDate = $releaseDate;
        $this->duration = $duration;
        $this->isDeleted = $isDeleted;
        $this->accessiblePath = $accessiblePath;
        $this->genres = [];
        $this->reviews = [];
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

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    public function getReleaseDate(): ?DateTime
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(DateTime $releaseDate): void
    {
        $this->releaseDate = $releaseDate;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function addGenre(GenreModel $genre): void
    {
        if (!in_array($genre, $this->genres, true)) {
            $this->genres[] = $genre;
        }
    }

    public function removeGenre(GenreModel $genre): void
    {
        $key = array_search($genre, $this->genres, true);

        if ($key) {
            unset($this->genres[$key]);
        }
    }

    public function getReviews(): array
    {
        return $this->reviews;
    }

    public function addReview(ReviewModel $review): void
    {
        if (!in_array($review, $this->reviews, true)) {
            $this->reviews[] = $review;
            $review->setMovies($this);
        }
    }

    public function getAccessiblePath(): string
    {
        return $this->accessiblePath;
    }

    public function setAccessiblePath($accessiblePath): void
    {
        $this->accessiblePath = $accessiblePath;
    }
}
