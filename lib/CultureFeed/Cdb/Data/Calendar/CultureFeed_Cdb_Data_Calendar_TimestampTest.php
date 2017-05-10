<?php

class CultureFeed_Cdb_Data_Calendar_TimestampTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider endDateDataProvider
     * @param string $date
     * @param string $startTime
     * @param string $endTime
     * @param string $expectedEndDate
     */
    public function it_gets_end_date(
        $date,
        $startTime,
        $endTime,
        $expectedEndDate
    ) {
        $timestamp = new \CultureFeed_Cdb_Data_Calendar_Timestamp(
            $date,
            $startTime,
            $endTime
        );

        $this->assertEquals($expectedEndDate, $timestamp->getEndDate());
    }

    /**
     * return array
     */
    public function endDateDataProvider()
    {
        return [
            [
                '2017-08-01',
                '20:00:00',
                '03:00:00',
                '2017-08-02',
            ],
            [
                '2017-08-01',
                '20:00:00',
                '20:00:00',
                '2017-08-01',
            ],
            [
                '2017-08-01',
                null,
                '23:00:00',
                '2017-08-01',
            ],
            [
                '2017-08-01',
                '20:00:00',
                null,
                '2017-08-01',
            ],
            [
                '2017-08-01',
                null,
                null,
                '2017-08-01',
            ],
        ];
    }
}
