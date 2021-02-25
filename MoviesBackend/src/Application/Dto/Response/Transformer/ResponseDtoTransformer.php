<?php

namespace App\Application\Dto\Response\Transformer;

abstract class ResponseDtoTransformer implements ResponseDtoTransformerInterface
{
    public function transformFromObjects(array $objects): array
    {
        $dtos = [];

        foreach ($objects as $object) {
            $dtos[] = $this->transformFromObject($object);
        }

        return $dtos;
    }

}