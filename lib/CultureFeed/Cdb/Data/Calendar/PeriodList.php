<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_Calendar_PeriodList extends CultureFeed_Cdb_Data_Calendar implements CultureFeed_Cdb_IElement
{
    public function add(CultureFeed_Cdb_Data_Calendar_Period $period): void
    {
        $this->items[] = $period;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $calendarElement = $dom->createElement('calendar');
        $element->appendChild($calendarElement);

        $periodElement = $dom->createElement('periods');
        $calendarElement->appendChild($periodElement);

        foreach ($this as $period) {
            $period->appendToDom($periodElement);
        }
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Calendar_PeriodList
    {
        $periodList = new CultureFeed_Cdb_Data_Calendar_PeriodList();

        if (!empty($xmlElement->periods->period)) {
            foreach ($xmlElement->periods->period as $periodElement) {
                $periodList->add(
                    CultureFeed_Cdb_Data_Calendar_Period::parseFromCdbXml(
                        $periodElement
                    )
                );
            }
        }

        return $periodList;
    }
}
