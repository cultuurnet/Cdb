<?php

use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Data_Address_PhysicalAddressTest extends TestCase
{
    public function loadSample(string $fileName): SimpleXMLElement
    {
        $sampleDir = __DIR__ . '/samples/PhysicalAddressTest/';
        $filePath = $sampleDir . $fileName;

        return simplexml_load_file($filePath);
    }

    public function testParseFull(): void
    {
        $sample = $this->loadSample('full.xml');

        $address = CultureFeed_Cdb_Data_Address_PhysicalAddress::parseFromCdbXml(
            $sample
        );

        $this->assertEquals('Brussel', $address->getCity());
        $this->assertEquals('BE', $address->getCountry());
        $this->assertEquals('1000', $address->getZip());

        $this->assertEquals('62', $address->getHouseNumber());
        $this->assertEquals('Sint-Gisleinstraat', $address->getStreet());
        $geo = $address->getGeoInformation();

        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_Address_GeoInformation',
            $geo
        );
        $this->assertEquals('4,3488', $geo->getXCoordinate());
        $this->assertEquals('50,8391', $geo->getYCoordinate());
    }

    public function testParseMinimal(): void
    {
        $sample = $this->loadSample('minimal.xml');

        $address = CultureFeed_Cdb_Data_Address_PhysicalAddress::parseFromCdbXml(
            $sample
        );

        $this->assertEquals('Brussel', $address->getCity());
        $this->assertEquals('BE', $address->getCountry());
        $this->assertEquals('1000', $address->getZip());

        $this->assertNull($address->getHouseNumber());
        $this->assertNull($address->getStreet());
        $this->assertNull($address->getGeoInformation());
    }

    /**
     * @dataProvider missingElementSamples
     */
    public function testParseXMLWithMissingElementThrowsException(string $sampleName): void
    {
        $this->expectException(CultureFeed_Cdb_ParseException::class);

        $sample = $this->loadSample($sampleName);
        CultureFeed_Cdb_Data_Address_PhysicalAddress::parseFromCdbXml($sample);
    }

    /**
     * @return array<array<string>>
     */
    public function missingElementSamples(): array
    {
        return array(
            array('missing_city.xml'),
            array('missing_country.xml'),
            array('missing_zipcode.xml'),
        );
    }
}
