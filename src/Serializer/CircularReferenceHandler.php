<?php

namespace App\Serializer;


class CircularReferenceHandler
{
    public function __invoke($entity)
    {
        return $entity->id;
    }
}
