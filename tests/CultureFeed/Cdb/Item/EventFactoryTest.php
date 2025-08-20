<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Item_EventFactoryTest extends TestCase
{
    /**
     * @dataProvider actorToEventDataProvider
     */
    public function testFromActor(\CultureFeed_Cdb_Item_Actor $actor, \CultureFeed_Cdb_Item_Event $expectedEvent): void
    {
        $actualEvent = CultureFeed_Cdb_Item_EventFactory::fromActor($actor);
        $this->assertEquals($expectedEvent, $actualEvent);
    }

    /**
     * @return array<array{\CultureFeed_Cdb_Item_Actor,\CultureFeed_Cdb_Item_Event}>
     */
    public function actorToEventDataProvider(): array
    {
        return [
            [
                \CultureFeed_Cdb_Item_Actor::parseFromCdbXml(
                    $this->loadSample('actor.xml')
                ),
                \CultureFeed_Cdb_Item_Event::parseFromCdbXml(
                    $this->loadSample('event.xml')
                ),
            ],
            [
                \CultureFeed_Cdb_Item_Actor::parseFromCdbXml(
                    $this->loadSample('actor-with-weekscheme.xml')
                ),
                \CultureFeed_Cdb_Item_Event::parseFromCdbXml(
                    $this->loadSample('event-with-weekscheme.xml')
                ),
            ],
        ];
    }

    private function loadSample(string $fileName): \SimpleXMLElement
    {
        $sampleDir = __DIR__ . '/samples/EventFactoryTest/';
        $filePath = $sampleDir . $fileName;

        $xml = simplexml_load_file(
            $filePath,
            'SimpleXMLElement',
            0,
            'http://www.cultuurdatabank.com/XMLSchema/CdbXSD/3.3/FINAL'
        );

        return $xml;
    }
}
