<?php

namespace LinkORB\Realm\Serializer\Normalizer;

use Symfony\Component\Serializer\SerializerAwareTrait;
use Symfony\Component\Serializer\SerializerAwareInterface;

use LinkORB\Realm\Model\Property;

/**
 * Base class for Normalizers of objects which use PropertyTrait.
 */
abstract class PropertiesNormalizer implements SerializerAwareInterface
{
    use SerializerAwareTrait;

    public function normalizeProperties($object, $format = null, array $context = array())
    {
        $normalized = [];
        foreach ($object->getProperties() as $lang => $propertiesByName) {
            foreach ($propertiesByName as $name => $property) {
                $normalized[] = $this->serializer->normalize($property, $format, $context);
            }
        }
        return $normalized;
    }

    public function denormalizeProperties($data, $format = null, array $context = array())
    {
        if (!isset($data[0]) || !is_array($data[0])) {
            // the decoder didn't make a list of "property" because there was only one "property"
            $data = [$data];
        }
        $denormalized = [];
        foreach ($data as $propertyData) {
            $denormalized[] = $this->serializer->denormalize($propertyData, Property::class, $format, $context);
        }
        return $denormalized;
    }
}
