<?php

use PHPUnit\Framework\TestCase;

/**
 * Created by PhpStorm.
 * User: Kristof
 * Date: 12/12/13
 * Time: 19:46
 */
class CultureFeed_Cdb_Data_Calendar_WeekschemeTest extends TestCase
{
    public function testAppendToDOM()
    {
        $open = CultureFeed_Cdb_Data_Calendar_SchemeDay::SCHEMEDAY_OPEN_TYPE_OPEN;
        $closed = CultureFeed_Cdb_Data_Calendar_SchemeDay::SCHEMEDAY_OPEN_TYPE_CLOSED;

        $ws = new CultureFeed_Cdb_Data_Calendar_Weekscheme();

        /** @var CultureFeed_Cdb_Data_Calendar_SchemeDay[] $days */
        $days = array();
        $days[] = new CultureFeed_Cdb_Data_Calendar_SchemeDay(
            CultureFeed_Cdb_Data_Calendar_SchemeDay::MONDAY,
            $closed
        );
        $days[] = new CultureFeed_Cdb_Data_Calendar_SchemeDay(
            CultureFeed_Cdb_Data_Calendar_SchemeDay::TUESDAY,
            $open
        );
        $days[] = new CultureFeed_Cdb_Data_Calendar_SchemeDay(
            CultureFeed_Cdb_Data_Calendar_SchemeDay::WEDNESDAY,
            $open
        );
        $days[] = new CultureFeed_Cdb_Data_Calendar_SchemeDay(
            CultureFeed_Cdb_Data_Calendar_SchemeDay::THURSDAY,
            $closed
        );
        $days[] = new CultureFeed_Cdb_Data_Calendar_SchemeDay(
            CultureFeed_Cdb_Data_Calendar_SchemeDay::FRIDAY,
            $open
        );
        $days[] = new CultureFeed_Cdb_Data_Calendar_SchemeDay(
            CultureFeed_Cdb_Data_Calendar_SchemeDay::SATURDAY,
            $open
        );
        $days[] = new CultureFeed_Cdb_Data_Calendar_SchemeDay(
            CultureFeed_Cdb_Data_Calendar_SchemeDay::SUNDAY,
            $closed
        );

        foreach ($days as $day) {
            $ws->setDay($day->getDayName(), $day);
        }

        $dom = new DOMDocument('1.0', 'utf8');
        $root = $dom->createElement('period');
        $dom->appendChild($root);
        $ws->appendToDOM($root);

        $this->assertXmlStringEqualsXmlFile(
            __DIR__ . '/samples/weekscheme.xml',
            $dom->saveXML()
        );
    }
}
