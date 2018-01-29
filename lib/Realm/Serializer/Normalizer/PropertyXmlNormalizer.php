<?php

namespace LinkORB\Realm\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use LinkORB\Realm\Model\Property;

/**
 * Property normalization and denormalization for XML.
 */
class PropertyXmlNormalizer implements DenormalizerInterface, NormalizerInterface
{
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Property && 'xml' === $format;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        $data = [];
        if ($object->hasName()) {
            $data['@name'] = $object->getName();
        }
        if ($object->hasLanguage()) {
            $data['@language'] = $object->getLanguage();
        }
        if ($object->hasValue()) {
            $data['#'] = $object->getValue();
        }
        return $data;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return Property::class === $type && 'xml' === $format;
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $object = new $class;
        if (isset($data['@name'])) {
            $object->setName((string) $data['@name']);
        }
        if (isset($data['@language'])) {
            $object->setLanguage((string) $data['@language']);
        }
        if (isset($data['#'])) {
            $object->setValue((string) $data['#']);
        }
        return $object;
    }
}
