<?php

/**
 * @class
 * Representation of an EventDetail element in the cdb xml.
 */
class CultureFeed_Cdb_Data_EventDetail extends CultureFeed_Cdb_Data_Detail implements CultureFeed_Cdb_IElement {

  /**
   * @var string
   */
  protected $calendarSummary;

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $detailElement = $dom->createElement('eventdetail');
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
   * @param string $summary
   */
  public function setCalendarSummary($summary) {
    $this->calendarSummary = $summary;
  }

  /**
   * @return string
   */
  public function getCalendarSummary() {
    return $this->calendarSummary;
  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return CultureFeed_Cdb_Data_EventDetailList
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    if (empty($xmlElement->title)) {
      throw new CultureFeed_ParseException("Title missing for eventdetail element");
    }

    $attributes = $xmlElement->attributes();
    if (empty($attributes['lang'])) {
      throw new CultureFeed_ParseException("Lang missing for eventdetail element");
    }

    $eventDetail = new Culturefeed_Cdb_Data_EventDetail();
    $eventDetail->setTitle((string)$xmlElement->title);
    $eventDetail->setLanguage((string)$attributes['lang']);

    if (!empty($xmlElement->shortdescription)) {
      $eventDetail->setShortDescription((string)$xmlElement->shortdescription);
    }

    if (!empty($xmlElement->longdescription)) {
      $eventDetail->setLongDescription((string)$xmlElement->longdescription);
    }

    if (!empty($xmlElement->calendarsummary)) {
      $eventDetail->setCalendarSummary((string)$xmlElement->calendarsummary);
    }

    return $eventDetail;

  }

}
