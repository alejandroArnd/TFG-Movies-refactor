<?php

namespace App\Application\Dto\Response\Transformer;

use App\Application\Dto\Response\SearchResponseDto;

class SearchResponseDtoTransformer extends ResponseDtoTransformer
{
    private MovieSearchResponseDtoTransformer $movieSearchResponseDtoTransformer;

    public function __construct(MovieSearchResponseDtoTransformer $movieSearchResponseDtoTransformer)
    {
        $this->movieSearchResponseDtoTransformer = $movieSearchResponseDtoTransformer;
    }
    public function transformFromObject($searchResponse): SearchResponseDto
    {
        $dto = new SearchResponseDto();
        $dto->setMoviesSearch($this->movieSearchResponseDtoTransformer->transformFromObjects($searchResponse->movies));
        $dto->setTotalItems($searchResponse->totalItems);

        return $dto;
    }
}