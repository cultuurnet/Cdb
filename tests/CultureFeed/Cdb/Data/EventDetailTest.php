<?php

class CultureFeed_Cdb_Data_EventDetailTest extends PHPUnit_Framework_TestCase
{
    public function testGeneratesMediaElementIfFilesWereAdded()
    {
        $detail = new CultureFeed_Cdb_Data_EventDetail();

        $media = $detail->getMedia();

        $this->assertInstanceOf('\CultureFeed_Cdb_Data_Media', $media);
        $this->assertCount(0, $media);

        $file = new CultureFeed_Cdb_Data_File();
        $file->setMediaType($file::MEDIA_TYPE_WEBRESOURCE);
        $file->setHLink('http://www.cultuurnet.be');

        $media->add($file);

        $dom = new DOMDocument();
        $eventElement = $dom->createElement('event');
        $dom->appendChild($eventElement);
        $detail->appendToDOM($eventElement);

        $xpath = new DOMXPath($dom);

        $items = $xpath->query('/event/eventdetail');
        $this->assertEquals(1, $items->length);

        $items = $xpath->query('/event/eventdetail/media');
        $this->assertEquals(1, $items->length);

        $items = $xpath->query('/event/eventdetail/media/file');
        $this->assertEquals(1, $items->length);
    }

    public function testDoesNotGenerateEmptyMediaElement()
    {
        $detail = new CultureFeed_Cdb_Data_EventDetail();

        $media = $detail->getMedia();

        $this->assertInstanceOf('\CultureFeed_Cdb_Data_Media', $media);
        $this->assertCount(0, $media);

        $dom = new DOMDocument();
        $eventElement = $dom->createElement('event');
        $dom->appendChild($eventElement);
        $detail->appendToDOM($eventElement);

        $xpath = new DOMXPath($dom);
        $items = $xpath->query('/event/eventdetail');
        $this->assertEquals(1, $items->length);

        $items = $xpath->query('/event/eventdetail/media');
        $this->assertEquals(0, $items->length);
    }
}
