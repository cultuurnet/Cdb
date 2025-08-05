<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Data_UrlTest extends TestCase
{
    use CultureFeed_Cdb_DOMElementAssertionsTrait;

    public function loadSample(string $fileName): DOMDocument
    {
        $sampleDir = __DIR__ . '/samples/UrlTest/';
        $filePath = $sampleDir . $fileName;

        $dom = new DOMDocument();
        $dom->load($filePath);

        return $dom;
    }

    public function testAppendsUrlAsTextNode(): void
    {
        $sample = $this->loadSample('minimal.xml');

        $urlString = 'http://example.com/?foo=1&bar=2';
        $url = new CultureFeed_Cdb_Data_Url($urlString, false, false);

        $dom = new DOMDocument();
        $contactInfoNode = $dom->createElement('contactinfo');
        $dom->appendChild($contactInfoNode);
        $url->appendToDOM($contactInfoNode);

        $xpath = new DOMXPath($dom);
        $items = $xpath->query('/contactinfo/url');
        $this->assertEquals(1, $items->length);

        $this->assertEqualDOMElement(
            $sample->documentElement,
            $items->item(0)
        );
    }

    public function testGetUrlReturnsUrlSetBefore(): void
    {
        $urlString = 'http://example.com/?foo=1&bar=2';
        $url = new CultureFeed_Cdb_Data_Url($urlString, false, false);
        $this->assertEquals($urlString, $url->getUrl());
    }

    public function testIsMainReturnMainSetBefore(): void
    {
        $urlString = 'http://example.com/?foo=1&bar=2';

        $url = new CultureFeed_Cdb_Data_Url($urlString, false, false);
        $this->assertEquals(false, $url->isMain());

        $url->setMain(true);
        $this->assertEquals(true, $url->isMain());

        $url = new CultureFeed_Cdb_Data_Url($urlString, true, false);
        $this->assertEquals(true, $url->isMain());

        $url->setMain(false);
        $this->assertEquals(false, $url->isMain());
    }
}
