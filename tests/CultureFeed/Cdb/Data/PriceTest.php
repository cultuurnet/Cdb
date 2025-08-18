<?php

declare(strict_types=1);

namespace CultureFeed\Cdb\Data;

use CultureFeed_Cdb_Data_Price;
use DOMDocument;
use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Data_PriceTest extends TestCase
{
    public function testParseNoPriceValue(): void
    {
        $sample = $this->loadSample('no_pricevalue.xml');

        $price = CultureFeed_Cdb_Data_Price::parseFromCdbXml(simplexml_import_dom($sample));

        $this->assertNull($price->getValue());
        $this->assertEquals('Basistarief: 0,00 €', $price->getDescription());
    }

    public function testParseFreeEntrance(): void
    {
        $sample = $this->loadSample('free.xml');

        $price = CultureFeed_Cdb_Data_Price::parseFromCdbXml(simplexml_import_dom($sample));

        $this->assertEquals('0', $price->getValue());
        $this->assertEquals('Basistarief: 0,00 €', $price->getDescription());
    }

    private function loadSample(string $fileName): DOMDocument
    {
        $sampleDir = __DIR__ . '/samples/PriceTest/';
        $filePath = $sampleDir . $fileName;

        $dom = new DOMDocument();
        $dom->load($filePath);

        return $dom;
    }
}
