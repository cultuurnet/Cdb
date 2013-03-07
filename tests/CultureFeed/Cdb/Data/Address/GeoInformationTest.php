<?php

class CultureFeed_Cdb_Data_Address_GeoInformationTest extends PHPUnit_Framework_TestCase
{
    public function sampleCoordinates() {
        return array(
            array('4,34890', '50,84740, '),
            array('4,3488', '50,8391'),
        );
    }

    /**
     * @dataProvider sampleCoordinates
     *
     * @param string $x
     * @param string $y
     */
    public function testXYGettersReturnConstructorInjectedValues($x, $y) {
        $geo = new CultureFeed_Cdb_Data_Address_GeoInformation($x, $y);

        $this->assertEquals($x, $geo->getXCoordinate());
        $this->assertEquals($y, $geo->getYCoordinate());
    }

    /**
     * @dataProvider sampleCoordinates
     *
     * @param string $x
     * @param string $y
     */
    public function testXYGettersReturnSetterInjectedValues($x, $y) {
        $geo = new CultureFeed_Cdb_Data_Address_GeoInformation('4,7139', '50,88162');

        $geo->setXCoordinate($x);
        $geo->setYCoordinate($y);

        $this->assertEquals($x, $geo->getXCoordinate());
        $this->assertEquals($y, $geo->getYCoordinate());
    }
}
