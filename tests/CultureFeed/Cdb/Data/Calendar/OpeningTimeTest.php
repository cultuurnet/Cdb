<?php

class OpeningTimeTest extends PHPUnit_Framework_TestCase
{
    public function testOpeningHoursWithEmptyFrom()
    {
        $xml = new SimpleXMLElement(
            file_get_contents(__DIR__ . '/samples/openingTime.xml')
        );

        $ws = CultureFeed_Cdb_Data_Calendar_Weekscheme::parseFromCdbXml(
            $xml
        );

        /** @var CultureFeed_Cdb_Data_Calendar_OpeningTime[] $tuesdayOpeningTimes */
        $tuesdayOpeningTimes = $ws->tuesday()->getOpeningTimes();

        $this->assertEquals("00:00:00", $tuesdayOpeningTimes[0]->getOpenFrom());
    }
}
