<?php

declare(strict_types=1);

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
        return [
            ['missing_city.xml'],
            ['missing_country.xml'],
            ['missing_zipcode.xml'],
        ];
    }


    public function testAppendToDom(): void
    {
        $physicalAddress = new \CultureFeed_Cdb_Data_Address_PhysicalAddress();
        $physicalAddress->setStreet('Sint & Gisleinstraat');
        $physicalAddress->setHouseNumber('61 & 62');
        $physicalAddress->setZip('1000');
        $physicalAddress->setCity('Brussel');
        $physicalAddress->setCountry('BE');

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $dom->preserveWhiteSpace = false;

        // The physical address can only be appended to another element,
        // not to the dom document. So we append it to a temporary root
        // element first.
        $rootElement = $dom->createElement('root');
        $dom->appendChild($rootElement);
        $physicalAddress->appendToDOM($rootElement);

        // Set <physical> as the root element.
        $xpath = new DOMXPath($dom);
        $items = $xpath->query('//physical');
        $this->assertEquals(1, $items->length);
        $addressElement = $items->item(0);
        $dom->removeChild($rootElement);
        $dom->appendChild($addressElement);

        $expectedCdbXml = file_get_contents(__DIR__ . '/samples/PhysicalAddressTest/street_special_character.xml');
        $actualCdbXml = $dom->saveXML();

        $this->assertEquals($expectedCdbXml, $actualCdbXml);
    }
}
