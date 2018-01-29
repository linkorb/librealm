<?php

namespace LinkORB\Realm\Serializer;

use LinkORB\Realm\RealmInterface;

interface SerializerInterface
{
    const FORMAT_XML = 'xml';

    /**
     * Serialize an object which represents the content of a Realm file.
     *
     * @param \LinkORB\Realm\RealmInterface $realm
     * @param array $context
     *
     * @return string
     */
    public function serialize(RealmInterface $realm, array $context = []);

    /**
     * Deserialize the content of a Realm file to an object which implements
     * RealmInterface.
     *
     * @param string $realmContent
     * @param string $type type of an object which implements RealmInterface
     * @param array $context
     *
     * @return \LinkORB\Realm\XliffInterface
     */
    public function deserialize($realmContent, $type, array $context = []);
}
