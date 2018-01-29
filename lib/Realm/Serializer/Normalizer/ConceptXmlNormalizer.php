<?php

namespace LinkORB\Realm\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

use LinkORB\Realm\Model\Concept;

/**
 * Concept normalization and denormalization for XML.
 */
class ConceptXmlNormalizer extends PropertiesNormalizer implements DenormalizerInterface, NormalizerInterface
{
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Concept && 'xml' === $format;
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
        if ($object->hasType()) {
            $data['@type'] = $object->getType();
        }
        if ($object->hasStatus()) {
            $data['@status'] = $object->getStatus();
        }
        if ($object->hasDataType()) {
            $data['@dataType'] = $object->getDataType();
        }
        if ($object->hasCodelistId()) {
            $data['@codelist'] = $object->getCodelistId();
        }
        if ($object->hasLengthMin()) {
            $data['@lengthMin'] = $object->getLengthMin();
        }
        if ($object->hasLengthMax()) {
            $data['@lengthMax'] = $object->getLengthMax();
        }
        if ($object->hasUnit()) {
            $data['@unit'] = $object->getUnit();
        }
        if ($object->hasProperties()) {
            $data['property'] = $this->normalizeProperties($object, $format, $context);
        }
        return $data;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return Concept::class === $type && 'xml' === $format;
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
        if (isset($data['@type'])) {
            $object->setType((string) $data['@type']);
        }
        if (isset($data['@status'])) {
            $object->setStatus((string) $data['@status']);
        }
        if (isset($data['@dataType'])) {
            $object->setDataType((string) $data['@dataType']);
        }
        if (isset($data['@codelist'])) {
            $object->setCodelistId((string) $data['@codelist']);
        }
        if (isset($data['@lengthMin'])) {
            $object->setLengthMin((int) $data['@lengthMin']);
        }
        if (isset($data['@lengthMax'])) {
            $object->setLengthMax((int) $data['@lengthMax']);
        }
        if (isset($data['@unit'])) {
            $object->setUnit((string) $data['@unit']);
        }
        if (isset($data['property'])) {
            $object->setProperties($this->denormalizeProperties($data['property'], $format, $context));
        }
        return $object;
    }
}
