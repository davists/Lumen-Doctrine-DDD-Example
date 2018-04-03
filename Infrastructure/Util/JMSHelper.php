<?php
/**
 * Created by PhpStorm.
 * User: davi
 * Date: 3/16/17
 * Time: 5:15 PM
 */

namespace Infrastructure\Util;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;

/**
 * Class JsonHelper
 * @package RZ2\Commons\Infrastructure\Util
 */
class JMSHelper
{
    private $serializer;
    
    public function setMetadataPath($metadataPath)
    {
        $this->serializer =  SerializerBuilder::create()
            ->addMetadataDir($metadataPath)
            ->build();
        
        return $this;
    }
    
    public function toJson($entity)
    {
        return $this->serializer->serialize($entity, 'json',SerializationContext::create()->enableMaxDepthChecks());
    }
}