<?php

namespace LinkORB\Realm\Serializer;

use Symfony\Component\Serializer\Serializer as SymfonySerializer;

use LinkORB\Realm\RealmInterface;

/**
 * A thin decoration of the Symfony Serializer for developer convenience.
 */
class Serializer implements SerializerInterface
{
    private $serializer;

    public function setSerializer(SymfonySerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    public function serialize(RealmInterface $realm, array $context = [])
    {
        return $this->serializer->serialize($realm, SerializerInterface::FORMAT_XML, $context);
    }

    public function deserialize($realmContent, $type, array $context = [])
    {
        return $this->serializer->deserialize($realmContent, $type, SerializerInterface::FORMAT_XML, $context);
    }
}
