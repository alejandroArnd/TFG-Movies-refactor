<?php

namespace App\Application\UseCases\Movies;

use App\Application\Repository\MoviesRepository;
use App\Application\Dto\Response\SearchResponseDto;
use App\Application\Dto\Response\Transformer\SearchResponseDtoTransformer;

class FindMoviesBySeveralCriterias
{
    private MoviesRepository $moviesRepository;
    private SearchResponseDtoTransformer $searchResponseDtoTransformer;

    public function __construct(MoviesRepository $moviesRepository, SearchResponseDtoTransformer $searchResponseDtoTransformer)
    {
        $this->moviesRepository = $moviesRepository;
        $this->searchResponseDtoTransformer = $searchResponseDtoTransformer;
    }
    public function handle(object $criteriaParams): SearchResponseDto
    {
        $criteriaParams->page = empty($criteriaParams->page) ? 1 : $criteriaParams->page;
        $searchResponse = $this->moviesRepository->findMoviesBySeveralCriterias($criteriaParams);
        return  $this->searchResponseDtoTransformer->transformFromObject($searchResponse); 
    }
}