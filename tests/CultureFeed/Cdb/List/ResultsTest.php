<?php

/**
 * @file
 */
class CultureFeed_Cdb_List_ResultsTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param $fileName
     *
     * @return SimpleXMLElement
     */
    protected function loadSample($fileName)
    {
        $sampleDir = __DIR__ . '/samples/ResultsTest/';
        $filePath = $sampleDir . $fileName;

        return simplexml_load_file($filePath);
    }

    public function testParseFromCdbXml()
    {
        $xml = $this->loadSample('eventlist.xml');

        $list = CultureFeed_Cdb_List_Results::parseFromCdbXml($xml);

        $this->assertInstanceOf('CultureFeed_Cdb_List_Results', $list);

        // This should be checked, it does not seem work as expected currently.
        //$this->assertEquals(50, $list->getTotalResultsfound());

        $this->assertCount(50, $list);
        $this->assertContainsOnly('CultureFeed_Cdb_List_Item', $list);

        $list->rewind();

        /* @var CultureFeed_Cdb_List_Item $item */
        $item = $list->current();

        $this->assertEquals(
            'f00539b9-bace-44ac-8a55-9688f4155c1f',
            $item->getCdbId()
        );
        $this->assertEquals('test_images_1', $item->getExternalId());
        $this->assertEquals(
            'Event met meerdere afbeeldingen',
            $item->getTitle()
        );
        $this->assertEquals('short description', $item->getShortDescription());

        $list->next();

        $item = $list->current();

        $this->assertEquals(
            'c4948d7f-ed24-4b3d-b872-17277cd83a9d',
            $item->getCdbId()
        );
        $this->assertEquals('lve_eng_test2', $item->getExternalId());
        $this->assertEquals('Event title', $item->getTitle());
        $this->assertEquals(
            'English short description',
            $item->getShortDescription()
        );
    }

    public function testParseFromCdbXmlWithoutListNameAndItemName() {
        $xml = $this->loadSample('eventlist_v2.xml');

        $list = CultureFeed_Cdb_List_Results::parseFromCdbXml($xml);

        $this->assertInstanceOf('CultureFeed_Cdb_List_Results', $list);
        $this->assertCount(2, $list);
        $this->assertEquals(2, $list->getTotalResultsfound());
    }

    public function testParseFromCdbXmlWithoutListNameAndItemNameWithSource() {
        $xml = $this->loadSample('eventlist_v2.xml');

        $eventsXml = $xml->xpath('event');
        $eventXmlSource = $eventsXml[0];

        $list = CultureFeed_Cdb_List_Results::parseFromCdbXml($xml);

        /** @var CultureFeed_Cdb_Item_Event $item */
        $item = $list->current();

        $this->assertNotNull($item->getSource());
        $this->assertInstanceOf('SimpleXMLElement', $item->getSource());
        $this->assertEquals($eventXmlSource, $item->getSource());
    }
}
