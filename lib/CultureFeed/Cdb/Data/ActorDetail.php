<?php

/**
 * @class
 * Representation of an EventDetail element in the cdb xml.
 */
class CultureFeed_Cdb_Data_ActorDetail extends CultureFeed_Cdb_Data_Detail implements CultureFeed_Cdb_IElement {

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $detailElement = $dom->createElement('actordetail');
    $detailElement->setAttribute('lang', $this->language);

    if (!empty($this->shortDescription)) {
      $detailElement->appendChild($dom->createElement('shortdescription', htmlentities($this->shortDescription)));
    }

    $detailElement->appendChild($dom->createElement('title', htmlentities($this->title)));

    $element->appendChild($detailElement);

  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return self
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    if (empty($xmlElement->title)) {
      throw new CultureFeed_ParseException("Title missing for actordetail element");
    }

    $attributes = $xmlElement->attributes();
    if (empty($attributes['lang'])) {
      throw new CultureFeed_ParseException("Lang missing for actordetail element");
    }

    $actorDetail = new self();
    $actorDetail->setTitle((string)$xmlElement->title);
    $actorDetail->setLanguage((string)$attributes['lang']);

    if (!empty($xmlElement->shortdescription)) {
      $actorDetail->setShortDescription((string)$xmlElement->shortdescription);
    }

    return $actorDetail;

  }

}
