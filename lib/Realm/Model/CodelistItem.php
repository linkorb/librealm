<?php

namespace LinkORB\Realm\Model;

use InvalidArgumentException;

class CodelistItem implements PropertyAncestorInterface
{
    protected $code = '';

    protected $codeSystem = '';

    protected $displayName = '';

    /**
     * @var int
     */
    protected $level;

    protected $type = '';

    use PropertyTrait;

    public function getCode()
    {
        return $this->code;
    }

    public function hasCode()
    {
        return '' !== $this->code;
    }

    public function setCode($code)
    {
        if (!is_string($code)) {
            throw new InvalidArgumentException('Expected "name" to be a string.');
        }
        $this->code = $code;
    }

    public function getCodeSystem()
    {
        return $this->codeSystem;
    }

    public function hasCodeSystem()
    {
        return '' !== $this->codeSystem;
    }

    public function setCodeSystem($codeSystem)
    {
        if (!is_string($codeSystem)) {
            throw new InvalidArgumentException('Expected "codeSystem" to be a string.');
        }
        $this->codeSystem = $codeSystem;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function hasDisplayName()
    {
        return '' !== $this->displayName;
    }

    public function setDisplayName($displayName)
    {
        if (!is_string($displayName)) {
            throw new InvalidArgumentException('Expected "displayName" to be a string.');
        }
        $this->displayName = $displayName;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function hasLevel()
    {
        return null !== $this->level;
    }

    public function setLevel($level)
    {
        if (!is_int($level)) {
            throw new InvalidArgumentException('Expected "level" to be an integer.');
        }
        $this->level = $level;
    }

    public function getType()
    {
        return $this->type;
    }

    public function hasType()
    {
        return '' !== $this->type;
    }

    public function setType($type)
    {
        if (!is_string($type)) {
            throw new InvalidArgumentException('Expected "type" to be a string.');
        }
        $this->type = $type;
    }
}
