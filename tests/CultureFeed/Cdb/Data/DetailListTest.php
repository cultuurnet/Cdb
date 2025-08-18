<?php

declare(strict_types=1);

namespace CultureFeed\Cdb\Data;

use CultureFeed_Cdb_Data_Detail;
use CultureFeed_Cdb_Data_DetailList;
use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Data_DetailListTest extends TestCase
{
    private CultureFeed_Cdb_Data_DetailList $details;

    public function setUp(): void
    {
        $this->details = $this->getMockForAbstractClass('\CultureFeed_Cdb_Data_DetailList');
    }

    public function testGetFirstWithOneDetail(): void
    {
        $first = $this->createDetail();
        $first->setTitle('Foo bar');

        $this->details->add($first);

        $this->assertEquals($first, $this->details->getFirst());
    }

    public function testGetFirstWithMultipleDetails(): void
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

    public function testGetFirstWithNoDetails(): void
    {
        $this->assertNull($this->details->getFirst());
    }

    private function createDetail(): CultureFeed_Cdb_Data_Detail
    {
        /* @var CultureFeed_Cdb_Data_Detail $mock */
        $mock = $this->getMockForAbstractClass('\CultureFeed_Cdb_Data_Detail');
        return $mock;
    }
}
