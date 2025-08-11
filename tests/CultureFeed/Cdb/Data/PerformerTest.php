<?php

use PHPUnit\Framework\TestCase;

class CultureFeed_Cdb_Data_PerformerTest extends TestCase
{
    use CultureFeed_Cdb_DOMElementAssertionsTrait;

    /**
     * @param $fileName
     *
     * @return DOMDocument
     */
    public function loadSample($fileName)
    {
        $sampleDir = __DIR__ . '/samples/PerformerTest/';
        $filePath = $sampleDir . $fileName;

        $dom = new DOMDocument();
        $dom->load($filePath);

        return $dom;
    }

    public function testAppendsLabelElementContainingLabel()
    {
        $performer = new CultureFeed_Cdb_Data_Performer();
        $performer->setLabel('Simon & Garfunkel');

        $dom = new DOMDocument();
        $performersElement = $dom->createElement('performers');
        $dom->appendChild($performersElement);
        $performer->appendToDOM($performersElement);

        $xpath = new DOMXPath($dom);
        $items = $xpath->query('/performers/performer');
        $this->assertEquals(1, $items->length);

        $items = $xpath->query('/performers/performer/label');
        $this->assertEquals(1, $items->length);

        $labelElement = $items->item(0);

        $this->assertEquals('Simon & Garfunkel', $labelElement->textContent);
    }

    public function testAppendsRoleBeforeLabel()
    {
        $sample = $this->loadSample('full_with_label.xml');

        $performer = new CultureFeed_Cdb_Data_Performer();
        $performer->setLabel('Elvis');
        $performer->setRole('Zang');

        $dom = new DOMDocument();
        $performersElement = $dom->createElement('performers');
        $dom->appendChild($performersElement);
        $performer->appendToDOM($performersElement);

        $xpath = new DOMXPath($dom);
        $items = $xpath->query('/performers/performer');
        $this->assertEquals(1, $items->length);

        $this->assertEqualDOMElement(
            $sample->documentElement,
            $items->item(0)
        );
    }

    public function testDoesNotGenerateEmptyRoleElementWhenNoRoleWasSet()
    {
        $sample = $this->loadSample('without_role.xml');

        $performer = new CultureFeed_Cdb_Data_Performer();
        $performer->setLabel('Elvis');

        $dom = new DOMDocument();
        $performersElement = $dom->createElement('performers');
        $dom->appendChild($performersElement);
        $performer->appendToDOM($performersElement);

        $xpath = new DOMXPath($dom);
        $items = $xpath->query('/performers/performer');
        $this->assertEquals(1, $items->length);

        $this->assertEqualDOMElement(
            $sample->documentElement,
            $items->item(0)
        );
    }
}
