<?php

/**
 * @class
 * Representation of an EventDetail element in the cdb xml.
 */
class CultureFeed_Cdb_Data_ActorDetail extends CultureFeed_Cdb_Data_Detail implements CultureFeed_Cdb_IElement {

  public function __construct() {
    $this->media = new CultureFeed_Cdb_Data_Media();
  }

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $detailElement = $dom->createElement('actordetail');
    $detailElement->setAttribute('lang', $this->language);

    if (!empty($this->shortDescription)) {
      $element = $dom->createElement('shortdescription');
      $element->appendChild($dom->createTextNode($this->shortDescription));
      $detailElement->appendChild($element);
    }

    if (!empty($this->longDescription)) {
      $element = $dom->createElement('longdescription');
      $element->appendChild($dom->createTextNode($this->longDescription));
      $detailElement->appendChild($element);
    }

    $titleElement = $dom->createElement('title');
    $titleElement->appendChild($dom->createTextNode($this->title));
    $detailElement->appendChild($titleElement);

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

    if (!empty($xmlElement->longdescription)) {
      $actorDetail->setLongDescription((string)$xmlElement->longdescription);
    }

    if (!empty($xmlElement->media->file)) {
      foreach ($xmlElement->media->file as $fileElement) {
        $actorDetail->media->add(CultureFeed_Cdb_Data_File::parseFromCdbXML($fileElement));
      }
    }

    return $actorDetail;

  }

}
