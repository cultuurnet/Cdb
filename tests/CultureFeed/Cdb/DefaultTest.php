<?php

class CultureFeed_Cdb_Default_DefaultTest extends PHPUnit_Framework_TestCase
{
    public function testConstructorWithSpecificVersion()
    {
        $cdbXml = new CultureFeed_Cdb_Default('3.2');
        $this->assertEquals(
            'http://www.cultuurdatabank.com/XMLSchema/CdbXSD/3.2/FINAL',
            $cdbXml->getSchemaUrl()
        );
        $this->assertEquals('3.2', $cdbXml->getSchemaVersion());
    }

    public function testConstructorWithoutSpecificVersion()
    {
      $cdbXml = new CultureFeed_Cdb_Default();
      $this->assertEquals($cdbXml::CDB_SCHEME_URL, $cdbXml->getSchemaUrl());
      $this->assertEquals($cdbXml::CDB_SCHEME_VERSION, $cdbXml->getSchemaVersion());
    }
}
