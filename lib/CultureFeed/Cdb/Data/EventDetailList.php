<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_EventDetailList extends CultureFeed_Cdb_Data_DetailList implements CultureFeed_Cdb_IElement
{
    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        /** @var DOMElement $detailsElement */
        $detailsElement = $dom->createElement('eventdetails');
        /** @var CultureFeed_Cdb_Data_EventDetail $detail */
        foreach ($this as $detail) {
            $detail->appendToDom($detailsElement);
        }

        $element->appendChild($detailsElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_EventDetailList
    {
        $detailList = new CultureFeed_Cdb_Data_EventDetailList();
        if (!empty($xmlElement->eventdetail)) {
            foreach ($xmlElement->eventdetail as $detailElement) {
                $detailList->add(
                    CultureFeed_Cdb_Data_EventDetail::parseFromCdbXml(
                        $detailElement
                    )
                );
            }
        }

        return $detailList;
    }
}
