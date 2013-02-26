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
}
