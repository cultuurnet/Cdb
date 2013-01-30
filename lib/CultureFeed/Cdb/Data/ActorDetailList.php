<?php

/**
 * @class
 * Representation of a list of event details in the cdb xml.
 */
class CultureFeed_Cdb_Data_ActorDetailList extends CultureFeed_Cdb_Data_DetailList implements CultureFeed_Cdb_IElement {

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $detailsElement = $dom->createElement('actordetails');
    foreach ($this as $detail) {
      $detail->appendToDom($detailsElement);
    }

    $element->appendChild($detailsElement);

  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return CultureFeed_Cdb_Data_EventDetailList
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    $detailList = new self();
    if (!empty($xmlElement->actordetail)) {
      foreach ($xmlElement->actordetail as $detailElement) {
        $detailList->add(CultureFeed_Cdb_Data_ActorDetail::parseFromCdbXml($detailElement));
      }
    }

    return $detailList;
  }

}
