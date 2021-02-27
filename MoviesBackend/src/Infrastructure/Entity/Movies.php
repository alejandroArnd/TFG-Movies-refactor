<?php

namespace App\Infrastructure\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use \App\Infrastructure\Entity\Genre;
use \App\Infrastructure\Entity\Review;

/**
 * @ORM\Entity
 */
class Movies
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", length=1000)
     */
    private $overview;

    /**
     * @ORM\Column(type="date")
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDeleted;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, inversedBy="movies")
     */
    private $genres;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="movies")
     */
    private $reviews;

    public function __construct(string $title, string $overview, DateTime $releaseDate, int $duration,  int $id = null, bool $isDeleted = false)
    {
        $this->id = $id;
        $this->title = $title;
        $this->overview = $overview;
        $this->releaseDate = $releaseDate;
        $this->duration = $duration;
        $this->isDeleted = $isDeleted;
        $this->genres = new ArrayCollection();
        $this->reviews = new ArrayCollection();
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

    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): void
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }
    }

    public function removeGenre(Genre $genre): void
    {
        $this->genres->removeElement($genre);
    }

    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): void
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setMovies($this);
        }
    }
}
