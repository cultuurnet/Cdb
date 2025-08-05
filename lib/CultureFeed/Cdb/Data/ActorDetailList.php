<?php declare(strict_types=1);

final class CultureFeed_Cdb_Data_ActorDetailList extends CultureFeed_Cdb_Data_DetailList implements CultureFeed_Cdb_IElement
{
    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $detailsElement = $dom->createElement('actordetails');
        /** @var CultureFeed_Cdb_Data_ActorDetail $detail */
        foreach ($this as $detail) {
            $detail->appendToDom($detailsElement);
        }

        $element->appendChild($detailsElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_ActorDetailList
    {
        $detailList = new self();
        if (!empty($xmlElement->actordetail)) {
            foreach ($xmlElement->actordetail as $detailElement) {
                $detailList->add(
                    CultureFeed_Cdb_Data_ActorDetail::parseFromCdbXml(
                        $detailElement
                    )
                );
            }
        }

        return $detailList;
    }
}
