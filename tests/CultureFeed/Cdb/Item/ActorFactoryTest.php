<?php

class CultureFeed_Cdb_Item_Actor_FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider eventToActorDataProvider
     * @param CultureFeed_Cdb_Item_Event $event
     * @param CultureFeed_Cdb_Item_Actor $expectedActor
     */
    public function testFromEvent(\CultureFeed_Cdb_Item_Event $event, \CultureFeed_Cdb_Item_Actor $expectedActor)
    {
        $actualActor = \CultureFeed_Cdb_Item_ActorFactory::fromEvent($event);
        $this->assertEquals($expectedActor, $actualActor);
    }

    /**
     * @return array
     */
    public function eventToActorDataProvider()
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
        ];
    }

    /**
     * @param string $fileName
     * @return SimpleXMLElement
     */
    private function loadSample($fileName)
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
