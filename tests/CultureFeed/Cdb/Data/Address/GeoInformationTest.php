<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Data_Address_GeoInformationTest extends TestCase
{
    /**
     * @return array<array<string>>
     */
    public function sampleCoordinates(): array
    {
        return [
            ['4,34890', '50,84740'],
            ['4,3488', '50,8391'],
        ];
    }

    /**
     * @dataProvider sampleCoordinates
     */
    public function testXYGettersReturnConstructorInjectedValues(string $x, string $y): void
    {
        $geo = new CultureFeed_Cdb_Data_Address_GeoInformation($x, $y);

        $this->assertEquals($x, $geo->getXCoordinate());
        $this->assertEquals($y, $geo->getYCoordinate());
    }

    /**
     * @dataProvider sampleCoordinates
     */
    public function testXYGettersReturnSetterInjectedValues(string $x, string $y): void
    {
        $geo = new CultureFeed_Cdb_Data_Address_GeoInformation(
            '4,7139',
            '50,88162'
        );

        $geo->setXCoordinate($x);
        $geo->setYCoordinate($y);

        $this->assertEquals($x, $geo->getXCoordinate());
        $this->assertEquals($y, $geo->getYCoordinate());
    }
}
