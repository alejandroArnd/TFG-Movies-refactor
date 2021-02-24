<?php

namespace App\Domain\Model;

use DateTime;
use App\Domain\Model\GenreModel;

class MoviesModel
{

    private $id;
    private $title;
    private $overview;
    private $releaseDate;
    private $duration;
    private $isDeleted;
    private $genres;

    public function __construct(string $title, string $overview, DateTime $releaseDate, int $duration, int $id = null, bool $isDeleted = false)
    {
        $this->id = $id;
        $this->title = $title;
        $this->overview = $overview;
        $this->releaseDate = $releaseDate;
        $this->duration = $duration;
        $this->isDeleted = $isDeleted;
        $this->genres = [];
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
}
