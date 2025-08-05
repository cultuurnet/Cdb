<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Data_Calendar_PeriodTest extends TestCase
{
    public function testAppendToDOM(): void
    {
        $from = '2013-12-06';
        $to = '2013-12-25';
        $period = new CultureFeed_Cdb_Data_Calendar_Period($from, $to);

        $scheme = new CultureFeed_Cdb_Data_Calendar_Weekscheme();

        $scheme->monday()->setOpen();
        $scheme->tuesday()->setOpen();
        $scheme->wednesday()->setOpen();
        $scheme->thursday()->setOpenByAppointment();
        $scheme->friday()->setOpen();
        $scheme->saturday()->setClosed();
        $scheme->sunday()->setClosed();

        $period->setWeekScheme($scheme);

        $dom = new DOMDocument('1.0', 'utf8');
        $root = $dom->createElement('calendar');
        $dom->appendChild($root);

        $period->appendToDOM($root);

        $this->assertXmlStringEqualsXmlFile(
            __DIR__ . '/samples/period.xml',
            $dom->saveXML()
        );
    }
}
