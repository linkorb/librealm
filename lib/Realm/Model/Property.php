<?php

namespace LinkORB\Realm\Model;

use InvalidArgumentException;

class Property
{
    protected $name = '';

    protected $language = '';

    protected $value = '';

    public function getName()
    {
        return $this->name;
    }

    public function hasName()
    {
        return '' !== $this->name;
    }

    public function setName($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('Expected "name" to be a string.');
        }
        $this->name = $name;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function hasLanguage()
    {
        return '' !== $this->language;
    }

    public function setLanguage($language)
    {
        if (!is_string($language)) {
            throw new InvalidArgumentException('Expected "language" to be a string.');
        }
        $this->language = $language;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function hasValue()
    {
        return '' !== $this->value;
    }

    public function setValue($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('Expected "value" to be a string.');
        }
        $this->value = $value;
    }
}
