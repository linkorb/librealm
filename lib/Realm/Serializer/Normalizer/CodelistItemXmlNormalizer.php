<?php

namespace LinkORB\Realm\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use LinkORB\Realm\Model\CodelistItem;

/**
 * CodelistItem normalization and denormalization for XML.
 */
class CodelistItemXmlNormalizer extends PropertiesNormalizer implements DenormalizerInterface, NormalizerInterface
{
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof CodelistItem && 'xml' === $format;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        $data = [];
        if ($object->hasCode()) {
            $data['@code'] = $object->getCode();
        }
        if ($object->hasCodeSystem()) {
            $data['@codeSystem'] = $object->getCodeSystem();
        }
        if ($object->hasDisplayName()) {
            $data['@displayName'] = $object->getDisplayName();
        }
        if ($object->hasLevel()) {
            $data['@level'] = $object->getLevel();
        }
        if ($object->hasType()) {
            $data['@type'] = $object->getType();
        }
        if ($object->hasProperties()) {
            $data['property'] = $this->normalizeProperties($object, $format, $context);
        }
        return $data;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return CodelistItem::class === $type && 'xml' === $format;
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $object = new $class;
        if (isset($data['@code'])) {
            $object->setCode((string) $data['@code']);
        }
        if (isset($data['@codeSystem'])) {
            $object->setCodeSystem((string) $data['@codeSystem']);
        }
        if (isset($data['@displayName'])) {
            $object->setDisplayName((string) $data['@displayName']);
        }
        if (isset($data['@type'])) {
            $object->setType((string) $data['@type']);
        }
        if (isset($data['@level'])) {
            $object->setLevel((int) $data['@level']);
        }
        if (isset($data['property'])) {
            $object->setProperties($this->denormalizeProperties($data['property'], $format, $context));
        }
        return $object;
    }
}
