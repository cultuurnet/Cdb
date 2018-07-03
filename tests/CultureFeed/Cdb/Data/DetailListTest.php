<?php

class CultureFeed_Cdb_Data_DetailListTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \CultureFeed_Cdb_Data_DetailList
     */
    private $details;

    public function setUp()
    {
        $this->details = $this->getMockForAbstractClass('\CultureFeed_Cdb_Data_DetailList');
    }

    public function testGetFirstWithOneDetail()
    {
        $first = $this->createDetail();
        $first->setTitle('Foo bar');

        $this->details->add($first);

        $this->assertEquals($first, $this->details->getFirst());
    }

    public function testGetFirstWithMultipleDetails()
    {
        $first = $this->createDetail();
        $first->setTitle('Foo bar');

        $second = $this->createDetail();
        $second->setTitle('Lorem ipsum');

        $third = $this->createDetail();
        $third->setTitle('Acme');

        $this->details->add($first);
        $this->details->add($second);
        $this->details->add($third);

        $this->assertEquals($first, $this->details->getFirst());
    }

    public function testGetFirstWithNoDetails()
    {
        $this->assertNull($this->details->getFirst());
    }

    /**
     * @return CultureFeed_Cdb_Data_Detail
     */
    private function createDetail()
    {
        /* @var CultureFeed_Cdb_Data_Detail $mock */
        $mock = $this->getMockForAbstractClass('\CultureFeed_Cdb_Data_Detail');
        return $mock;
    }
}
