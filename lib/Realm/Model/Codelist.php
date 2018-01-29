<?php

namespace LinkORB\Realm\Model;

use InvalidArgumentException;

class Codelist implements PropertyAncestorInterface
{
    protected $id = '';

    protected $oid = '';

    protected $shortName = '';

    protected $displayName = '';

    protected $status = '';
    /**
     * @var \LinkORB\Realm\Model\CodelistItem[]
     */
    protected $items = [];

    use PropertyTrait;

    public function getId()
    {
        return $this->id;
    }

    public function hasId()
    {
        return '' !== $this->id;
    }

    public function setId($id)
    {
        if (!is_string($id)) {
            throw new InvalidArgumentException('Expected "id" to be a string.');
        }
        $this->id = $id;
    }

    public function getOid()
    {
        return $this->oid;
    }

    public function hasOid()
    {
        return '' !== $this->oid;
    }

    public function setOid($oid)
    {
        if (!is_string($oid)) {
            throw new InvalidArgumentException('Expected "oid" to be a string.');
        }
        $this->oid = $oid;
    }

    public function getShortName()
    {
        return $this->shortName;
    }

    public function hasShortName()
    {
        return '' !== $this->shortName;
    }

    public function setShortName($shortName)
    {
        if (!is_string($shortName)) {
            throw new InvalidArgumentException('Expected "shortName" to be a string.');
        }
        $this->shortName = $shortName;
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

    public function getStatus()
    {
        return $this->status;
    }

    public function hasStatus()
    {
        return '' !== $this->status;
    }

    public function setStatus($status)
    {
        if (!is_string($status)) {
            throw new InvalidArgumentException('Expected "status" to be a string.');
        }
        $this->status = $status;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function hasItems()
    {
        return !empty($this->items);
    }

    public function setItems(array $items)
    {
        $this->items = [];
        array_map([$this, 'addItem'], $items);
    }

    public function getItem($code)
    {
        if (!$this->hasItem($code)) {
            return null;
        }
        return $this->items[$code];
    }

    public function hasItem($code)
    {
        return isset($this->items[$code]);
    }

    public function addItem(CodelistItem $item)
    {
        $this->items[$item->getCode()] = $item;
    }
}
