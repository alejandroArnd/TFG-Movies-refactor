<?php

namespace App\Domain\Model;

class GenreModel
{
    
    private $id;
    private $name;
    private $movies;

    public function __construct(string $name, int $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMovies(): array
    {
        return $this->movies;
    }
}
