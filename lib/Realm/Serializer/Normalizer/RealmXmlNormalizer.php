<?php

namespace LinkORB\Realm\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

use LinkORB\Realm\Model\Codelist;
use LinkORB\Realm\Model\Concept;
use LinkORB\Realm\Model\Realm;

/**
 * Realm normalization and denormalization for XML.
 */
class RealmXmlNormalizer implements DenormalizerInterface, NormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Realm && 'xml' === $format;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        $data = [];
        foreach ($object->getConcepts() as $id => $concept) {
            $data['concept'][] = $this->serializer->normalize($concept, $format, $context);
        }
        foreach ($object->getCodelists() as $id => $codelist) {
            $data['codelist'][] = $this->serializer->normalize($codelist, $format, $context);
        }
        return $data;
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return Realm::class === $type && 'xml' === $format;
    }

    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $object = new $class;
        if (isset($data['concept'])) {
            if (!isset($data['concept'][0]) || !is_array($data['concept'][0])) {
                $data['concept'] = [$data['concept']];
            }
            foreach ($data['concept'] as $conceptData) {
                $object->addConcept($this->serializer->denormalize($conceptData, Concept::class, $format, $context));
            }
        }
        if (isset($data['codelist'])) {
            if (!isset($data['codelist'][0]) || !is_array($data['codelist'][0])) {
                $data['codelist'] = [$data['codelist']];
            }
            foreach ($data['codelist'] as $codelistData) {
                $object->addCodelist($this->serializer->denormalize($codelistData, Codelist::class, $format, $context));
            }
        }
        return $object;
    }
}
