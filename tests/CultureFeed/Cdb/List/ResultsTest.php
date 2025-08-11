<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_List_ResultsTest extends TestCase
{
    protected function loadSample(string $fileName): SimpleXMLElement
    {
        $sampleDir = __DIR__ . '/samples/ResultsTest/';
        $filePath = $sampleDir . $fileName;

        return simplexml_load_file($filePath);
    }

    public function testParseFromCdbXml(): void
    {
        $xml = $this->loadSample('eventlist.xml');

        $list = CultureFeed_Cdb_List_Results::parseFromCdbXml($xml);

        $this->assertInstanceOf('CultureFeed_Cdb_List_Results', $list);

        // This should be checked, it does not seem work as expected currently.
        $this->assertEquals(50, $list->getTotalResultsfound());

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
}
