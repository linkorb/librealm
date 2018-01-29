<?php

namespace LinkORB\Realm\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use LinkORB\Realm\Model\Codelist;
use LinkORB\Realm\Model\CodelistItem;

/**
 * Codelist normalization and denormalization for XML.
 */
class CodelistXmlNormalizer extends PropertiesNormalizer implements DenormalizerInterface, NormalizerInterface
{
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Codelist && 'xml' === $format;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        $data = [];
        if ($object->hasId()) {
            $data['@id'] = $object->getId();
        }
        if ($object->hasOid()) {
            $data['@oid'] = $object->getOid();
        }
        if ($object->hasShortName()) {
            $data['@shortName'] = $object->getShortName();
        }
        if ($object->hasDisplayName()) {
            $data['@displayName'] = $object->getDisplayName();
        }
        if ($object->hasStatus()) {
            $data['@status'] = $object->getStatus();
        }
        foreach ($object->getItems() as $code => $item) {
            $data['item'][] = $this->serializer->normalize($item, $format, $context);
        }
        if ($object->hasProperties()) {
            $data['property'] = $this->normalizeProperties($object, $format, $context);
        }
        return $data;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return Codelist::class === $type && 'xml' === $format;
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $object = new $class;
        if (isset($data['@id'])) {
            $object->setId((string) $data['@id']);
        }
        if (isset($data['@oid'])) {
            $object->setOid((string) $data['@oid']);
        }
        if (isset($data['@shortName'])) {
            $object->setShortName((string) $data['@shortName']);
        }
        if (isset($data['@displayName'])) {
            $object->setDisplayName((string) $data['@displayName']);
        }
        if (isset($data['@status'])) {
            $object->setStatus((string) $data['@status']);
        }
        if (isset($data['item'])) {
            if (!isset($data['item'][0]) || !is_array($data['item'][0])) {
                $data['item'] = [$data['item']];
            }
            foreach ($data['item'] as $itemData) {
                $object->addItem($this->serializer->denormalize($itemData, CodelistItem::class, $format, $context));
            }
        }
        if (isset($data['property'])) {
            $object->setProperties($this->denormalizeProperties($data['property'], $format, $context));
        }
        return $object;
    }
}
