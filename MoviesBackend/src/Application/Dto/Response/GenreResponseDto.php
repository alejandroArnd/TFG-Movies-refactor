<?php

namespace App\Application\Dto\Response;

class GenreResponseDto
{
    public string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }
}