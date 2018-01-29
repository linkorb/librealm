<?php

namespace Test\Realm\Model;

use PHPUnit_Framework_TestCase;
use SimpleXMLElement;

use LinkORB\Realm\Model\Codelist;
use LinkORB\Realm\Model\CodelistItem;
use LinkORB\Realm\Model\Concept;
use LinkORB\Realm\Model\Property;
use LinkORB\Realm\Model\Realm;
use LinkORB\Realm\Serializer\SerializerConfigurator;

class SerializationTest extends PHPUnit_Framework_TestCase
{
    private $serializer;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->serializer = $this->buildSerializer();
    }

    private function buildSerializer()
    {
        $cfg = new SerializerConfigurator;
        return $cfg->buildSerializer();
    }

    public function testDeserialiseProperty()
    {
        $object = $this->serializer->deserialize(
            '<property name="name" language="nl-NL">Zorgverlener/Zorginstelling</property>',
            Property::class,
            'xml'
        );
        $this->assertSame('Zorgverlener/Zorginstelling', $object->getValue());
        $this->assertSame('name', $object->getName());
        $this->assertSame('nl-NL', $object->getLanguage());
    }

    public function testDeserialiseCodelistItem()
    {
        $object = $this->serializer->deserialize(
            '<item code="112144000" codeSystem="2.16.840.1.113883.6.96" displayName="Blood group A (finding)" type="L" level="1"><property name="name" language="nl-NL">A</property></item>',
            CodelistItem::class,
            'xml'
        );
        $this->assertSame('112144000', $object->getCode());
        $this->assertSame('2.16.840.1.113883.6.96', $object->getCodeSystem());
        $this->assertSame('Blood group A (finding)', $object->getDisplayName());
        $this->assertSame('L', $object->getType());
        $this->assertSame(1, $object->getLevel());
        $this->assertTrue(
            $object->hasProperty('name', 'nl_NL'),
            'A Property of the CodelistItem was deserialised.'
        );
    }

    public function testDeserialiseCodelist()
    {
        $object = $this->serializer->deserialize(
            '<codelist id="AB0BloodGroup" oid="1.2.3.4" shortName="bloodgroup" displayName="Blood Group" status="final"><item code="112144000"><property name="name" language="nl-NL">A</property></item></codelist>',
            Codelist::class,
            'xml'
        );
        $this->assertSame('AB0BloodGroup', $object->getId());
        $this->assertSame('1.2.3.4', $object->getOid());
        $this->assertSame('bloodgroup', $object->getShortName());
        $this->assertSame('Blood Group', $object->getDisplayName());
        $this->assertSame('final', $object->getStatus());
        $this->assertTrue(
            $object->hasItem('112144000'),
            'A CodelistItem of the Codelist was deserialised.'
        );
        $this->assertTrue(
            $object->getItem('112144000')->hasProperty('name', 'nl_NL'),
            'A Property of the CodelistItem (of the Codelist) was deserialised.'
        );
    }

    public function testDeserialiseConcept()
    {
        $object = $this->serializer->deserialize(
            '<concept id="peri22-dataelement-1" oid="1.2.3.4" shortName="zorgverlenerzorginstelling" type="group" status="final" codelist="1" dataType="thing" lengthMin="0" lengthMax="99100" unit="G"><property name="name" language="nl-NL">A</property></concept>',
            Concept::class,
            'xml'
        );
        $this->assertSame('peri22-dataelement-1', $object->getId());
        $this->assertSame('1.2.3.4', $object->getOid());
        $this->assertSame('zorgverlenerzorginstelling', $object->getShortName());
        $this->assertSame('group', $object->getType());
        $this->assertSame('final', $object->getStatus());
        $this->assertSame('1', $object->getCodelistId());
        $this->assertSame('thing', $object->getDataType());
        $this->assertSame(0, $object->getLengthMin());
        $this->assertSame(99100, $object->getLengthMax());
        $this->assertSame('G', $object->getUnit());
        $this->assertTrue(
            $object->hasProperty('name', 'nl_NL'),
            'A Property of the Concept was deserialised.'
        );
    }

    public function testDeserialiseRealm()
    {
        $object = $this->serializer->deserialize(
            '<realm><concept id="peri22-dataelement-1"><property name="name" language="nl-NL">A</property></concept><codelist id="AB0BloodGroup"><item code="112144000"><property name="name" language="nl-NL">A</property></item></codelist></realm>',
            Realm::class,
            'xml'
        );
        $this->assertTrue(
            $object->hasConcept('peri22-dataelement-1'),
            'A Concept of the Realm was deserialised.'
        );
        $this->assertTrue(
            $object->getConcept('peri22-dataelement-1')->hasProperty('name', 'nl_NL'),
            'A Property of the Concept (of the Realm) was deserialised.'
        );
        $this->assertTrue(
            $object->hasCodelist('AB0BloodGroup'),
            'A Codelist of the Realm was deserialised.'
        );
        $this->assertTrue(
            $object->getCodelist('AB0BloodGroup')->hasItem('112144000'),
            'A CodelistItem of the Codelist (of the Realm) was deserialised.'
        );
        $this->assertTrue(
            $object->getCodelist('AB0BloodGroup')->getItem('112144000')->hasProperty('name', 'nl_NL'),
            'A Property of the CodelistItem (of the Codelist of the Realm) was deserialised.'
        );
    }

    public function testSerialiseProperty()
    {
        $object = new Property();
        $object->setName('name');
        $object->setLanguage('nl_NL');
        $object->setValue('A');

        $elem = new SimpleXMLElement(
            $this->serializer->serialize($object, 'xml', ['xml_root_node_name' => 'property'])
        );

        $this->assertSame('name', (string) $elem->xpath('/property[1]/@name')[0]);
        $this->assertSame('nl_NL', (string) $elem->xpath('/property[1]/@language')[0]);
        $this->assertSame('A', (string) $elem->xpath('/property[1]/text()')[0]);

        return $object;
    }

    /**
     * @depends testSerialiseProperty
     * @param Property $property
     */
    public function testSerialiseCodelistItem(Property $property)
    {
        $object = new CodelistItem();
        $object->setCode('112144000');
        $object->setCodeSystem('1.2.3.4');
        $object->setDisplayName('Blood group A (finding)');
        $object->setType('L');
        $object->setLevel(1);
        $object->addProperty($property);
        $anotherProperty = clone $property;
        $anotherProperty->setLanguage('en');
        $object->addProperty($anotherProperty);

        $elem = new SimpleXMLElement(
            $this->serializer->serialize($object, 'xml', ['xml_root_node_name' => 'item'])
        );

        $this->assertSame('112144000', (string) $elem->xpath('/item[1]/@code')[0]);
        $this->assertSame('1.2.3.4', (string) $elem->xpath('/item[1]/@codeSystem')[0]);
        $this->assertSame('Blood group A (finding)', (string) $elem->xpath('/item[1]/@displayName')[0]);
        $this->assertSame('L', (string) $elem->xpath('/item[1]/@type')[0]);
        $this->assertSame('1', (string) $elem->xpath('/item[1]/@level')[0]);
        $this->assertCount(2, $elem->xpath('/item/property'));

        return $object;
    }

    /**
     * @depends testSerialiseCodelistItem
     * @param CodelistItem $codelistItem
     */
    public function testSerialiseCodelist(CodelistItem $codelistItem)
    {
        $object = new Codelist;
        $object->setId('AB0BloodGroup');
        $object->setOid('1.2.3.4');
        $object->setShortName('bloodgroup');
        $object->setDisplayName('Blood Group');
        $object->setStatus('final');
        $object->addItem($codelistItem);

        $elem = new SimpleXMLElement(
            $this->serializer->serialize($object, 'xml', ['xml_root_node_name' => 'codelist'])
        );

        $this->assertSame('AB0BloodGroup', (string) $elem->xpath('/codelist[1]/@id')[0]);
        $this->assertSame('1.2.3.4', (string) $elem->xpath('/codelist[1]/@oid')[0]);
        $this->assertSame('bloodgroup', (string) $elem->xpath('/codelist[1]/@shortName')[0]);
        $this->assertSame('Blood Group', (string) $elem->xpath('/codelist[1]/@displayName')[0]);
        $this->assertSame('final', (string) $elem->xpath('/codelist[1]/@status')[0]);
        $this->assertCount(1, $elem->xpath('/codelist/item'));

        return $object;
    }

    /**
     * @depends testSerialiseProperty
     * @param Property $property
     */
    public function testSerialiseConcept(Property $property)
    {
        $object = new Concept();
        $object->setId('peri22-dataelement-1');
        $object->setOid('1.2.3.4');
        $object->setShortName('zorgverlenerzorginstelling');
        $object->setType('group');
        $object->setStatus('final');
        $object->setCodelistId('5678');
        $object->setDataType('thing');
        $object->setLengthMin(0);
        $object->setLengthMax(99100);
        $object->setUnit('G');
        $object->addProperty($property);

        $elem = new SimpleXMLElement(
            $this->serializer->serialize($object, 'xml', ['xml_root_node_name' => 'concept'])
        );

        $this->assertSame('peri22-dataelement-1', (string) $elem->xpath('/concept[1]/@id')[0]);
        $this->assertSame('1.2.3.4', (string) $elem->xpath('/concept[1]/@oid')[0]);
        $this->assertSame('zorgverlenerzorginstelling', (string) $elem->xpath('/concept[1]/@shortName')[0]);
        $this->assertSame('group', (string) $elem->xpath('/concept[1]/@type')[0]);
        $this->assertSame('final', (string) $elem->xpath('/concept[1]/@status')[0]);
        $this->assertSame('5678', (string) $elem->xpath('/concept[1]/@codelist')[0]);
        $this->assertSame('thing', (string) $elem->xpath('/concept[1]/@dataType')[0]);
        $this->assertSame(0, (int) $elem->xpath('/concept[1]/@lengthMin')[0]);
        $this->assertSame(99100, (int) $elem->xpath('/concept[1]/@lengthMax')[0]);
        $this->assertSame('G', (string) $elem->xpath('/concept[1]/@unit')[0]);
        $this->assertCount(1, $elem->xpath('/concept/property'));

        return $object;
    }

    /**
     * @depends testSerialiseConcept
     * @depends testSerialiseCodelist
     * @param Concept $concept
     * @param Codelist $codelist
     */
    public function testSerialiseRealm(Concept $concept, Codelist $codelist)
    {
        $object = new Realm;
        $object->addConcept($concept);
        $object->addCodelist($codelist);

        $elem = new SimpleXMLElement(
            $this->serializer->serialize($object, 'xml', ['xml_root_node_name' => 'realm'])
        );

        $this->assertCount(1, $elem->xpath('/realm/concept'));
        $this->assertCount(1, $elem->xpath('/realm/codelist'));
    }
}
