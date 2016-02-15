<?php

/**
 * @class
 * Representation of a list of production details in the cdb xml.
 */
class CultureFeed_Cdb_Data_ProductionDetailList extends CultureFeed_Cdb_Data_DetailList implements CultureFeed_Cdb_IElement
{
    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMElement $element)
    {

        $dom = $element->ownerDocument;

        $detailsElement = $dom->createElement('productiondetails');
        foreach ($this as $detail) {
            $detail->appendToDom($detailsElement);
        }

        $element->appendChild($detailsElement);
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_ProductionDetailList
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
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
