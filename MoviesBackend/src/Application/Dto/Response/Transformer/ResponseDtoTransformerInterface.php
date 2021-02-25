<?php

namespace App\Application\Dto\Response\Transformer;

interface ResponseDtoTransformerInterface
{
    public function transformFromObject(object $object);

    public function transformFromObjects(array $objects): array;
}