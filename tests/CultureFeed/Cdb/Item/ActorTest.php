<?php

use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Item_ActorTest extends TestCase
{
    public function loadSample(string $fileName, string $cdbScheme = '3.2'): SimpleXMLElement
    {
        $sampleDir = __DIR__ . '/samples/ActorTest/cdbxml-' . $cdbScheme . '/';
        $filePath = $sampleDir . $fileName;

        $file = file_get_contents($filePath);
        $xml = simplexml_load_string($file);

        return $xml;
    }

    public function testParseCdbXml(): void
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

    public function testParseCdbXmlWithoutCategories(): void
    {
        $this->expectException(CultureFeed_Cdb_ParseException::class);
        $this->expectExceptionMessage('Categories missing for actor element');

        $xml = $this->loadSample('actor-no-categories.xml');
        CultureFeed_Cdb_Item_Actor::parseFromCdbXml($xml);
    }

    public function testParseCdbXmlWithoutActorDetails(): void
    {
        $this->expectException(CultureFeed_Cdb_ParseException::class);
        $this->expectExceptionMessage('Actordetails missing for actor element');

        $xml = $this->loadSample('actor-no-actordetails.xml');
        CultureFeed_Cdb_Item_Actor::parseFromCdbXml($xml);
    }
}
