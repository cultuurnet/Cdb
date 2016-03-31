<?php

class CultureFeed_Cdb_Data_LocationTest extends PHPUnit_Framework_TestCase
{
    public function testLoadExternalIdFromXml()
    {
        $filePath = __DIR__ . '/samples/LocationTest/location-with-externalid.xml';
        $xml = simplexml_load_file($filePath);

        $location = CultureFeed_Cdb_Data_Location::parseFromCdbXml($xml);
        $this->assertEquals(
            'https://beta.uitdatabank.be/place/af58cf0f-0887-4265-8966-0f7cf4d6be84',
            $location->getExternalid()
        );
        $this->assertEquals(
            '2dotstwice headquarters',
            $location->getLabel()
        );
    }
    
    public function testAppendExternalIdToXml()
    {
        // load sample data
        $filePath = __DIR__ . '/samples/LocationTest/location-with-externalid.xml';
        $xml = simplexml_load_file($filePath);

        $location = CultureFeed_Cdb_Data_Location::parseFromCdbXml($xml);

        // append to dom
        $dom = new DOMDocument();
        $eventElement = $dom->createElement('event');
        $dom->appendChild($eventElement);

        $location->appendToDOM($eventElement);

        $xpath = new DOMXPath($dom);

        $items = $xpath->query(
            "/event/location/label[@externalid='https://beta.uitdatabank.be/place/af58cf0f-0887-4265-8966-0f7cf4d6be84']"
        );
        $this->assertEquals(1, $items->length);
    }
}
