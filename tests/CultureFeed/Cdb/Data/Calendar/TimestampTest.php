<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Data_Calendar_TimestampTest extends TestCase
{
    /**
     * @dataProvider endDateDataProvider
     */
    public function testGetEndDate(
        string $date,
        ?string $startTime,
        ?string $endTime,
        string $expectedEndDate
    ): void {
        $timestamp = new \CultureFeed_Cdb_Data_Calendar_Timestamp(
            $date,
            $startTime,
            $endTime
        );

        $this->assertEquals($expectedEndDate, $timestamp->getEndDate());
    }

    /** @return array<array<string|null>> */
    public function endDateDataProvider(): array
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
