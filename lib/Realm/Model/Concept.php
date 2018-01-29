<?php

namespace LinkORB\Realm\Model;

use InvalidArgumentException;

class Concept implements PropertyAncestorInterface
{
    protected $id = '';

    protected $oid = '';

    protected $shortName = '';

    protected $type = '';

    protected $status = '';

    protected $dataType = '';

    protected $codelistId = '';

    /**
     * @var int
     */
    protected $lengthMin;

    /**
     * @var int
     */
    protected $lengthMax;

    protected $unit = '';

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

    public function getCodelistId()
    {
        return $this->codelistId;
    }

    public function hasCodelistId()
    {
        return '' !== $this->codelistId;
    }

    public function setCodelistId($codelistId)
    {
        if (!is_string($codelistId)) {
            throw new InvalidArgumentException('Expected "codelistId" to be a string.');
        }
        $this->codelistId = $codelistId;
    }

    public function getDataType()
    {
        return $this->dataType;
    }

    public function hasDataType()
    {
        return '' !== $this->dataType;
    }

    public function setDataType($dataType)
    {
        if (!is_string($dataType)) {
            throw new InvalidArgumentException('Expected "dataType" to be a string.');
        }
        $this->dataType = $dataType;
    }

    public function getLengthMin()
    {
        return $this->lengthMin;
    }

    public function hasLengthMin()
    {
        return null !== $this->lengthMin;
    }

    public function setLengthMin($lengthMin)
    {
        if (!is_int($lengthMin)) {
            throw new InvalidArgumentException('Expected "lengthMin" to be an integer.');
        }
        $this->lengthMin = $lengthMin;
    }

    public function getLengthMax()
    {
        return $this->lengthMax;
    }

    public function hasLengthMax()
    {
        return null !== $this->lengthMax;
    }

    public function setLengthMax($lengthMax)
    {
        if (!is_int($lengthMax)) {
            throw new InvalidArgumentException('Expected "lengthMax" to be an integer.');
        }
        $this->lengthMax = $lengthMax;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function hasUnit()
    {
        return '' !== $this->unit;
    }

    public function setUnit($unit)
    {
        if (!is_string($unit)) {
            throw new InvalidArgumentException('Expected "unit" to be a string.');
        }
        $this->unit = $unit;
    }
}
