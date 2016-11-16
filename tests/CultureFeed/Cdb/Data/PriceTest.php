<?php

/**
 * @file
 */
class CultureFeed_Cdb_Data_PriceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param $fileName
     *
     * @return DOMDocument
     */
    public function loadSample($fileName)
    {
        $sampleDir = __DIR__ . '/samples/PriceTest/';
        $filePath = $sampleDir . $fileName;

        $dom = new DOMDocument();
        $dom->load($filePath);

        return $dom;
    }

    public function testParseNoPriceValue()
    {
        $sample = $this->loadSample('no_pricevalue.xml');

        $price = CultureFeed_Cdb_Data_Price::parseFromCdbXml(simplexml_import_dom($sample));

        $this->assertNull($price->getValue());
        $this->assertEquals('Basistarief: 0,00 €', $price->getDescription());
    }

    public function testParseFreeEntrance()
    {
        $sample = $this->loadSample('free.xml');

        $price = CultureFeed_Cdb_Data_Price::parseFromCdbXml(simplexml_import_dom($sample));

        $this->assertEquals('0', $price->getValue());
        $this->assertEquals('Basistarief: 0,00 €', $price->getDescription());
    }
}
