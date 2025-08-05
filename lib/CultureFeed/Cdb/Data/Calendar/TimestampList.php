<?php declare(strict_types=1);

final class CultureFeed_Cdb_Data_Calendar_TimestampList extends CultureFeed_Cdb_Data_Calendar implements CultureFeed_Cdb_IElement
{
    public function add(CultureFeed_Cdb_Data_Calendar_Timestamp $timestamp): void
    {
        $this->items[] = $timestamp;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $calendarElement = $dom->createElement('calendar');
        $element->appendChild($calendarElement);

        $timestampsElement = $dom->createElement('timestamps');
        $calendarElement->appendChild($timestampsElement);

        foreach ($this as $timestamp) {
            $timestamp->appendToDom($timestampsElement);
        }
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Calendar_TimestampList
    {
        $timestampList = new CultureFeed_Cdb_Data_Calendar_TimestampList();
        if (!empty($xmlElement->timestamp)) {
            foreach ($xmlElement->timestamp as $timestampElement) {
                $timestampList->add(
                    CultureFeed_Cdb_Data_Calendar_Timestamp::parseFromCdbXml(
                        $timestampElement
                    )
                );
            }
        }

        return $timestampList;
    }
}
