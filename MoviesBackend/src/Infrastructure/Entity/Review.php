<?php

namespace App\Infrastructure\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Review
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
     * @ORM\Column(type="text")
     */
    private $paragraph;

    /**
     * @ORM\Column(type="float")
     */
    private $score;

    /**
     * @ORM\Column(type="date")
     */
    private $postingDate;

    /**
     * @ORM\ManyToOne(targetEntity=Movies::class, inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movies;

    public function __construct(string $title, string $paragraph, DateTime $postingDate, float $score, Movies $movies, int $id = null)
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

    public function getMovies(): ?Movies
    {
        return $this->movies;
    }

    public function setMovies(?Movies $movies): void
    {
        $this->movies = $movies;
    }
}
