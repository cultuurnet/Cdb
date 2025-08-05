<?php declare(strict_types=1);

final class CultureFeed_Cdb_Data_ProductionDetailList extends CultureFeed_Cdb_Data_DetailList implements CultureFeed_Cdb_IElement
{
    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $detailsElement = $dom->createElement('productiondetails');
        /** @var CultureFeed_Cdb_Data_ProductionDetail $detail */
        foreach ($this as $detail) {
            $detail->appendToDom($detailsElement);
        }

        $element->appendChild($detailsElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_ProductionDetailList
    {
        $detailList = new CultureFeed_Cdb_Data_ProductionDetailList();
        if (!empty($xmlElement->productiondetail)) {
            foreach ($xmlElement->productiondetail as $detailElement) {
                $detailList->add(
                    CultureFeed_Cdb_Data_ProductionDetail::parseFromCdbXml(
                        $detailElement
                    )
                );
            }
        }

        return $detailList;
    }
}
