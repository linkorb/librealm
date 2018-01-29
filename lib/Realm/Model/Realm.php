<?php

namespace LinkORB\Realm\Model;

use LinkORB\Realm\RealmInterface;

class Realm implements RealmInterface
{
    /**
     * @var \LinkORB\Realm\Model\Concept[]
     */
    protected $concepts = [];

    /**
     * @var \LinkORB\Realm\Model\Codelist[]
     */
    protected $codelists = [];

    public function setConcepts(array $concepts)
    {
        $this->concepts = [];
        array_map([$this, 'addConcept'], $concepts);
    }

    public function addConcept(Concept $concept)
    {
        $this->concepts[$concept->getId()] = $concept;
    }

    public function getConcepts()
    {
        return $this->concepts;
    }

    public function hasConcept($id)
    {
        return isset($this->concepts[$id]);
    }

    public function getConcept($id)
    {
        if (!$this->hasConcept($id)) {
            return null;
        }
        return $this->concepts[$id];
    }

    public function setCodelists(array $codelists)
    {
        $this->codelists = [];
        array_map([$this, 'addCodelist'], $codelists);
    }

    public function addCodelist(Codelist $codelist)
    {
        $this->codelists[$codelist->getId()] = $codelist;
    }

    public function getCodelists()
    {
        return $this->codelists;
    }

    public function hasCodelist($id)
    {
        return isset($this->codelists[$id]);
    }

    public function getCodelist($id)
    {
        if (!$this->hasCodelist($id)) {
            return null;
        }
        return $this->codelists[$id];
    }
}
