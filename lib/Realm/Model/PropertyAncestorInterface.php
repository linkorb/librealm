<?php

namespace LinkORB\Realm\Model;

/**
 * Interface for Realm objects that have a list of Property objects.
 */
interface PropertyAncestorInterface
{
    public function setProperties(array $properties);

    public function getProperties();

    public function getPropertiesInLanguage($languageCode);

    public function hasProperties();

    public function addProperty(Property $property);

    public function hasProperty($name, $languageCode);

    public function getProperty($name, $languageCode);

    public function removeProperty($name, $languageCode);
}
