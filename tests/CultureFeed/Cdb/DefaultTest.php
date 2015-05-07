<?php

class CultureFeed_Cdb_Default_DefaultTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CultureFeed_Cdb_Default
     */
    protected $default_no_arg;

    /**
     * @var CultureFeed_Cdb_Default
     */
    protected $default_with_arg;

    public function setUp()
    {
        $this->default_no_arg = new CultureFeed_Cdb_Default();
        $this->default_with_arg = new CultureFeed_Cdb_Default('3.2');
    }

    public function testConstructorWithArgument()
    {
        $this->assertEquals(
            'http://www.cultuurdatabank.com/XMLSchema/CdbXSD/3.2/FINAL',
            $this->default_with_arg->getSchemaUrl()
        );
        $this->assertEquals('3.2', $this->default_with_arg->getSchemaVersion());
    }

    public function testConstructorWithoutArgument()
    {
        $this->assertEquals(CultureFeed_Cdb_Default::CDB_SCHEME_URL, $this->default_no_arg->getSchemaUrl());
        $this->assertEquals('3.3', $this->default_no_arg->getSchemaVersion());
    }
}
