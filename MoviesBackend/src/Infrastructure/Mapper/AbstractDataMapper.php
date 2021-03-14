<?php

namespace App\Infrastructure\Mapper;

abstract class AbstractDataMapper
{
    public function toArrayModel(array $entities): array
    {
        $models = [];

        foreach($entities as $entity){
            $models[] = $this->toModel($entity);
        }
        
        return $models;
    }
}