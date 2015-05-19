<?php

class CultureFeed_Cdb_Default_DefaultTest extends PHPUnit_Framework_TestCase
{
  public function versionProvider() {
    return array(
      array('3.1'),
      array('3.2'),
      array('3.3'),
    );
  }

  /**
   * @dataProvider versionProvider
   * @param string $version
   */
    public function testConstructorWithSpecificVersion($version)
    {
        $cdbXml = new CultureFeed_Cdb_Default($version);
        $this->assertEquals(
          CultureFeed_Cdb_Xml::namespaceUriForVersion($version),
            $cdbXml->getSchemaUrl()
        );
        $this->assertEquals($version, $cdbXml->getSchemaVersion());
    }

    public function testConstructorWithoutSpecificVersion()
    {
      $cdbXml = new CultureFeed_Cdb_Default();
      $this->assertEquals(
        CultureFeed_Cdb_Xml::namespaceUriForVersion('3.2'),
        $cdbXml->getSchemaUrl()
      );
      $this->assertEquals('3.2', $cdbXml->getSchemaVersion());
    }
}
