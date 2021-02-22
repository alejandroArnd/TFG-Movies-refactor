<?php

namespace App\Infrastructure\Mapper;

abstract class AbstractDataMapper
{
    public function toArrayModel(array $moviesEntity): array
    {
        $moviesModel = [];

        foreach($moviesEntity as $movie){
            $moviesModel[] = $this->toModel($movie);
        }
        
        return $moviesModel;
    }
}