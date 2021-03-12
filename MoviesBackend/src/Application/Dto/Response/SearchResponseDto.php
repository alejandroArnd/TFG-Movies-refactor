<?php

namespace App\Application\Dto\Response;

class SearchResponseDto
{
    public array $moviesSearch;

    public int $totalItems;
 
    public function getMoviesSearch(): array
    {
        return $this->moviesSearch;
    }

    public function setMoviesSearch($moviesSearch): void
    {
        $this->moviesSearch = $moviesSearch;
    }

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    public function setTotalItems($totalItems): void
    {
        $this->totalItems = $totalItems;
    }
}