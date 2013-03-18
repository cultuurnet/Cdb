<?php

class CultureFeed_Cdb_Data_UrlTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param $fileName
     * @return DOMDocument
     */
    public function loadSample($fileName) {
        $sampleDir = __DIR__ . '/samples/UrlTest/';
        $filePath = $sampleDir . $fileName;

        $dom = new DOMDocument();
        $dom->load($filePath);

        return $dom;
    }

    public function testAppendsUrlAsTextNode() {
        $sample = $this->loadSample('minimal.xml');

        $urlString = 'http://example.com/?foo=1&bar=2';
        $url = new CultureFeed_Cdb_Data_Url($urlString, FALSE, FALSE);

        $dom = new DOMDocument();
        $contactInfoNode = $dom->createElement('contactinfo');
        $dom->appendChild($contactInfoNode);
        $url->appendToDOM($contactInfoNode);

        $xpath = new DOMXPath($dom);
        $items = $xpath->query('/contactinfo/url');
        $this->assertEquals(1, $items->length);

        $this->assertEqualXMLStructure($sample->documentElement, $items->item(0));
    }

    public function testGetUrlReturnsUrlSetBefore() {
        $urlString = 'http://example.com/?foo=1&bar=2';
        $url = new CultureFeed_Cdb_Data_Url($urlString, FALSE, FALSE);
        $this->assertEquals($urlString, $url->getUrl());

        $newUrlString = 'http://example.com';
        $url->setUrl($urlString);
        $url->setUrl($newUrlString, $url->getUrl());
    }

    public function testIsMainReturnMainSetBefore() {
        $urlString = 'http://example.com/?foo=1&bar=2';

        $url = new CultureFeed_Cdb_Data_Url($urlString, FALSE, FALSE);
        $this->assertEquals(FALSE, $url->isMain());

        $url->setMain(TRUE);
        $this->assertEquals(TRUE, $url->isMain());

        $url = new CultureFeed_Cdb_Data_Url($urlString, TRUE, FALSE);
        $this->assertEquals(TRUE, $url->isMain());

        $url->setMain(FALSE);
        $this->assertEquals(FALSE, $url->isMain());
    }
}
