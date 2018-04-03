<?php
namespace Infrastructure\Util;

use LaravelDoctrine\ORM\Serializers\JsonSerializer;
use LaravelDoctrine\ORM\Serializers\ArraySerializer;

class JsonHelper
{
    private $jsonSerializer;
    private $arraySerializer;

    public function __construct()
    {
        $this->jsonSerializer = new JsonSerializer();
        $this->arraySerializer = new ArraySerializer();
    }

    private function jsonTransform($entity, $serializer)
    {
        return $serializer->serialize($entity);
    }

    public function entityToJson($entity)
    {
        return $this->jsonTransform($entity, $this->jsonSerializer);
    }

    public function collectionToJson($collection)
    {
        $collectionToJson = [];

        foreach ($collection as $entity) {
            $collectionToJson[] = $this->jsonTransform($entity, $this->arraySerializer);
        }

        return json_encode($collectionToJson);
    }

    public function arrayToJson($array)
    {
        return json_encode($array);
    }
}
