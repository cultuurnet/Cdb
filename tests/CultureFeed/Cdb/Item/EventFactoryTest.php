<?php

class CultureFeed_Cdb_Item_Event_FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider actorToEventDataProvider
     * @param CultureFeed_Cdb_Item_Actor $actor
     * @param CultureFeed_Cdb_Item_Event $expectedEvent
     */
    public function testFromActor(\CultureFeed_Cdb_Item_Actor $actor, \CultureFeed_Cdb_Item_Event $expectedEvent)
    {
        $actualEvent = \CultureFeed_Cdb_Item_EventFactory::fromActor($actor);
        $this->assertEquals($expectedEvent, $actualEvent);
    }

    /**
     * @return array
     */
    public function actorToEventDataProvider()
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

    /**
     * @param string $fileName
     * @return SimpleXMLElement
     */
    private function loadSample($fileName)
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
