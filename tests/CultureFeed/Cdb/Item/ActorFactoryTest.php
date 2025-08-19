<?php

declare(strict_types=1);

namespace CultureFeed\Cdb\Item;

use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Item_Actor_FactoryTest extends TestCase
{
    /**
     * @dataProvider eventToActorDataProvider
     */
    public function testFromEvent(\CultureFeed_Cdb_Item_Event $event, \CultureFeed_Cdb_Item_Actor $expectedActor): void
    {
        $actualActor = \CultureFeed_Cdb_Item_ActorFactory::fromEvent($event);
        $this->assertEquals($expectedActor, $actualActor);
    }

    /**
     * @return array<array{\CultureFeed_Cdb_Item_Event,\CultureFeed_Cdb_Item_Actor}>
     */
    public function eventToActorDataProvider(): array
    {
        return [
            [
                \CultureFeed_Cdb_Item_Event::parseFromCdbXml(
                    $this->loadSample('event.xml')
                ),
                \CultureFeed_Cdb_Item_Actor::parseFromCdbXml(
                    $this->loadSample('actor.xml')
                ),
            ],
            [
                \CultureFeed_Cdb_Item_Event::parseFromCdbXml(
                    $this->loadSample('event-with-weekscheme.xml')
                ),
                \CultureFeed_Cdb_Item_Actor::parseFromCdbXml(
                    $this->loadSample('actor-with-weekscheme.xml')
                ),
            ],
            [
                \CultureFeed_Cdb_Item_Event::parseFromCdbXml(
                    $this->loadSample('event-without-contact-info.xml')
                ),
                \CultureFeed_Cdb_Item_Actor::parseFromCdbXml(
                    $this->loadSample('actor-without-contact-info.xml')
                ),
            ],
        ];
    }

    private function loadSample(string $fileName): \SimpleXMLElement
    {
        $sampleDir = __DIR__ . '/samples/ActorFactoryTest/';
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
