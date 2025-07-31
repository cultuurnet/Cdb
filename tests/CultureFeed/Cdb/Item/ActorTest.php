<?php

use PHPUnit\Framework\TestCase;

class CultureFeed_Cdb_Item_ActorTest extends TestCase
{
    public function setUp(): void
    {
        $this->actor = new CultureFeed_Cdb_Item_Actor();
    }

    /**
     * @param $fileName
     * @param $cdbScheme
     *
     * @return SimpleXMLElement
     */
    public function loadSample($fileName, $cdbScheme = '3.2')
    {
        $sampleDir = __DIR__ . '/samples/ActorTest/cdbxml-' . $cdbScheme . '/';
        $filePath = $sampleDir . $fileName;

        /*$xml = simplexml_load_file(
            $filePath,
            'SimpleXMLElement',
            0,
            'http://www.cultuurdatabank.com/XMLSchema/CdbXSD/' . $cdbScheme . '/FINAL'
        );*/
        $file = file_get_contents($filePath);
        $xml = simplexml_load_string($file);

        return $xml;
    }

    /**
     * Integration test for parsing  cdbxml version 3.2
     */
    public function testParseCdbXml()
    {
        $xml = $this->loadSample('actor.xml');
        $actor = CultureFeed_Cdb_Item_Actor::parseFromCdbXml($xml);

        $this->assertInstanceOf('CultureFeed_Cdb_Item_Actor', $actor);

        $this->assertEquals(
            'a761b5d6-0349-4dd4-a39f-c471b0fb64e8',
            $actor->getCdbId()
        );
        $this->assertEquals(
            'SKB Import:Organisation_488',
            $actor->getExternalId()
        );
        $this->assertEquals('2011-01-03T10:39:18', $actor->getAvailableFrom());
        $this->assertEquals('2100-01-01T00:00:00', $actor->getAvailableTo());
        $this->assertEquals('admin ferranti', $actor->getCreatedBy());
        $this->assertEquals('2010-01-19T04:59:14', $actor->getCreationDate());
        $this->assertEquals('2011-01-03T10:39:18', $actor->getLastUpdated());
        $this->assertEquals(
            'soetkin.vanassche@cultuurnet.be',
            $actor->getLastUpdatedBy()
        );
        $this->assertEquals('Invoerders Algemeen ', $actor->getOwner());
    }

    /**
     * @expectedException CultureFeed_Cdb_ParseException
     * @expectedExceptionMessage Categories missing for actor element
     */
    public function testParseCdbXmlWithoutCategories()
    {
        $xml = $this->loadSample('actor-no-categories.xml');
        CultureFeed_Cdb_Item_Actor::parseFromCdbXml($xml);
    }

    /**
     * @expectedException CultureFeed_Cdb_ParseException
     * @expectedExceptionMessage Actordetails missing for actor element
     */
    public function testParseCdbXmlWithoutActorDetails()
    {
        $xml = $this->loadSample('actor-no-actordetails.xml');
        CultureFeed_Cdb_Item_Actor::parseFromCdbXml($xml);
    }
}
