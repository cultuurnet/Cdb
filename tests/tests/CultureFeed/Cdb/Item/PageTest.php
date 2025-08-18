<?php

/**
 * @file
 */
class CultureFeed_Cdb_Item_PageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @param $fileName
     *
     * @return SimpleXMLElement
     */
    public function loadSample($fileName)
    {
        $sampleDir = __DIR__ . '/samples/PageTest/';
        $filePath = $sampleDir . $fileName;

        $xml = simplexml_load_file($filePath);

        return $xml;
    }

    public function testParsePage()
    {
        $xml = $this->loadSample('page.xml');

        $page = CultureFeed_Cdb_Item_Page::parseFromCdbXml($xml);

        $address = $page->getAddress();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_Address_PhysicalAddress',
            $address
        );

        $geo = $address->getGeoInformation();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_Address_GeoInformation',
            $geo
        );

        $this->assertEquals(5.3537689, $geo->getXCoordinate());
        $this->assertEquals(50.9216401, $geo->getYCoordinate());
    }
}
