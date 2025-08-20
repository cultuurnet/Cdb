<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Data_OpeningTimeTest extends TestCase
{
    public function testOpeningHoursWithEmptyFrom(): void
    {
        $xml = new SimpleXMLElement(
            file_get_contents(__DIR__ . '/samples/openingTime.xml')
        );

        $ws = CultureFeed_Cdb_Data_Calendar_Weekscheme::parseFromCdbXml(
            $xml
        );

        $tuesdayOpeningTimes = $ws->tuesday()->getOpeningTimes();

        $this->assertEquals('00:00:00', $tuesdayOpeningTimes[0]->getOpenFrom());
    }
}
