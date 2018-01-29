<?php

namespace LinkORB\Realm\Model;

use Locale;

trait PropertyTrait
{
    /**
     * @var \LinkORB\Realm\Model\Property[]
     */
    protected $properties = [];

    public function setProperties(array $properties)
    {
        $this->properties = [];
        array_map([$this, 'addProperty'], $properties);
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function getPropertiesInLanguage($languageCode)
    {
        if (!isset($this->properties[$this->normaliseLanguageCode($languageCode)])) {
            return [];
        }
        return $this->properties[$this->normaliseLanguageCode($languageCode)];
    }

    public function hasProperties()
    {
        return !empty($this->properties);
    }

    public function addProperty(Property $property)
    {
        $languageCode = $this->normaliseLanguageCode($property->getLanguage());
        $this->properties[$languageCode][$property->getName()] = $property;
    }

    public function hasProperty($name, $languageCode)
    {
        return isset(
            $this->properties[$this->normaliseLanguageCode($languageCode)][$name]
        );
    }

    public function getProperty($name, $languageCode)
    {
        if (!$this->hasProperty($name, $languageCode)) {
            return null;
        }
        return $this->properties[$this->normaliseLanguageCode($languageCode)][$name];
    }

    public function removeProperty($name, $languageCode)
    {
        unset($this->properties[$this->normaliseLanguageCode($languageCode)][$name]);
    }

    private function normaliseLanguageCode($languageCode)
    {
        if ('' === $languageCode) {
            return Language::LANG_NONE;
        }
        return Locale::canonicalize($languageCode);
    }
}
