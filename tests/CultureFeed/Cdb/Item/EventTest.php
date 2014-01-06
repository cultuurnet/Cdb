<?php

class CultureFeed_Cdb_Item_EventTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CultureFeed_Cdb_Item_Event
     */
    protected $event;

    public function setUp()
    {
        $this->event = new CultureFeed_Cdb_Item_Event();
    }

    /**
     * @param $fileName
     * @return SimpleXMLElement
     */
    public function loadSample($fileName) {
        $sampleDir = __DIR__ . '/samples/EventTest/';
        $filePath = $sampleDir . $fileName;

        $xml = simplexml_load_file($filePath, 'SimpleXMLElement', 0, \CultureFeed_Cdb_Default::CDB_SCHEME_URL);

        return $xml;
    }

    public function testAppendsCdbidAttributeOnlyWhenCdbidIsSet()
    {
        $this->assertEquals(NULL, $this->event->getCdbId());

        $dom = new DOMDocument();
        $eventsElement = $dom->createElement('events');
        $dom->appendChild($eventsElement);
        $this->event->appendToDOM($eventsElement);

        $xpath = new DOMXPath($dom);

        $items = $xpath->query('/events/event');
        $this->assertEquals(1, $items->length);

        $items = $xpath->query('/events/event/@cdbid');
        $this->assertEquals(0, $items->length);

        $uuid = '0FA6D598-F126-4B4F-BCE3-BAF3BD959A35';
        $this->event->setCdbId($uuid);
        $this->assertEquals($uuid, $this->event->getCdbId());

        $dom = new DOMDocument();
        $eventsElement = $dom->createElement('events');
        $dom->appendChild($eventsElement);
        $this->event->appendToDOM($eventsElement);

        $xpath = new DOMXPath($dom);

        $items = $xpath->query('/events/event');
        $this->assertEquals(1, $items->length);

        $items = $xpath->query('/events/event/@cdbid');
        $this->assertEquals(1, $items->length);

        $this->assertEquals($uuid, $items->item(0)->textContent);
    }

    /**
     * @return array
     */
    public function privatePropertyValues() {
        return array(
            array(TRUE),
            array(FALSE),
        );
    }

    /**
     * @dataProvider privatePropertyValues
     */
    public function testAppendsBooleanPrivateProperty($value) {
        $this->assertInternalType('boolean', $this->event->isPrivate());
        $this->assertEquals(FALSE, $this->event->isPrivate());

        $dom = new DOMDocument();
        $eventsElement = $dom->createElement('events');
        $dom->appendChild($eventsElement);
        $this->event->appendToDOM($eventsElement);

        $xpath = new DOMXPath($dom);

        $items = $xpath->query('/events/event');
        $this->assertEquals(1, $items->length);

        $items = $xpath->query('/events/event/@private');
        $this->assertEquals(0, $items->length);

        $this->event->setPrivate($value);

        $this->assertInternalType('boolean', $this->event->isPrivate());
        $this->assertEquals($value, $this->event->isPrivate());
    }

    public function privatePropertySamples() {
        return array(
          array('private.xml', TRUE),
          array('non-private.xml', FALSE),
        );
    }

    /**
     * @dataProvider privatePropertySamples
     * @param $sampleName
     * @param $value
     */
    public function testCreateFromXmlParsesPrivateAttribute($sampleName, $value) {
        $xml = $this->loadSample($sampleName);
        //var_dump($xml->asXML());
        $event = CultureFeed_Cdb_Item_Event::parseFromCdbXml($xml);

        $this->assertEquals($value, $event->isPrivate());
    }

    public function testParseCdbXMLGuideExample6Dot2() {
        $xml = $this->loadSample('cdbxml-guide-example-6-2.xml');

        $event = CultureFeed_Cdb_Item_Event::parseFromCdbXml($xml);

        $this->assertInstanceOf('CultureFeed_Cdb_Item_Event', $event);

        $this->assertEquals('ea37cae2-c91e-4810-89ab-e060432d2b78', $event->getCdbId());
        $this->assertEquals('2010-02-25T00:00:00', $event->getAvailableFrom());
        $this->assertEquals('2010-08-09T00:00:00', $event->getAvailableTo());
        $this->assertEquals('mverdoodt', $event->getCreatedBy());
        $this->assertEquals('2010-07-05T18:28:18', $event->getCreationDate());
        $this->assertEquals('SKB Import:SKB00001_216413', $event->getExternalId());
        $this->assertFalse($event->isParent());
        $this->assertEquals('2010-07-28T13:58:55', $event->getLastUpdated());
        $this->assertEquals('mverdoodt', $event->getLastUpdatedBy());
        $this->assertEquals('SKB Import', $event->getOwner());
        $this->assertEquals(80, $event->getPctComplete());
        $this->assertFalse($event->isPrivate());
        $this->assertTrue($event->isPublished());
        $this->assertEquals('SKB', $event->getValidator());
        $this->assertEquals('approved', $event->getWfStatus());

        $this->assertEquals(18, $event->getAgeFrom());

        $calendar = $event->getCalendar();

        $this->assertInstanceOf('CultureFeed_Cdb_Data_Calendar', $calendar);

        $this->assertCount(1, $calendar);

        $calendar->rewind();
        /** @var CultureFeed_Cdb_Data_Calendar_Timestamp $timestamp */
        $timestamp = $calendar->current();

        $this->assertInstanceOf('CultureFeed_Cdb_Data_Calendar_Timestamp', $timestamp);

        $this->assertEquals('2010-08-01', $timestamp->getDate());

        $this->assertEquals('21:00:00.0000000', $timestamp->getStartTime());

        $this->assertNULL($timestamp->getEndTime());


    }
}
