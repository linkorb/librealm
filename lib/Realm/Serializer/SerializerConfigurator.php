<?php

namespace LinkORB\Realm\Serializer;

use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

use LinkORB\Realm\Serializer\Normalizer\CodelistItemXmlNormalizer;
use LinkORB\Realm\Serializer\Normalizer\CodelistXmlNormalizer;
use LinkORB\Realm\Serializer\Normalizer\ConceptXmlNormalizer;
use LinkORB\Realm\Serializer\Normalizer\PropertyXmlNormalizer;
use LinkORB\Realm\Serializer\Normalizer\RealmXmlNormalizer;

/**
 * Configure the Serializer service.
 */
class SerializerConfigurator
{
    /**
     * Configure and build the Symfony Serializer and inject it into the
     * Serializer service.
     *
     * @param \LinkORB\Realm\Serializer\Serializer $serializer
     */
    public function configure(Serializer $serializer)
    {
        $serializer->setSerializer($this->buildSerializer());
    }

    public function buildSerializer()
    {
        $normalizers = [
            new ConceptXmlNormalizer,
            new CodelistXmlNormalizer,
            new CodelistItemXmlNormalizer,
            new PropertyXmlNormalizer,
            new RealmXmlNormalizer,
        ];
        $encoders = [
            new XmlEncoder,
        ];
        return new SymfonySerializer($normalizers, $encoders);
    }
}
