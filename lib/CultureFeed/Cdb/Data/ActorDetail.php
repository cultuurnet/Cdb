<?php

/**
 * @class
 * Representation of an EventDetail element in the cdb xml.
 */
class CultureFeed_Cdb_Data_ActorDetail extends CultureFeed_Cdb_Data_Detail implements CultureFeed_Cdb_IElement {

  /**
   * Calendar summary from this eventDetail.
   * @var string
   */
  protected $calendarSummary;

  /**
   * Construct the ActorDetail.
   */
  public function __construct() {
    $this->media = new CultureFeed_Cdb_Data_Media();
  }

  /**
   * Get the calendar summary.
   * @return string
   */
  public function getCalendarSummary() {
    return $this->calendarSummary;
  }

  /**
   * Set the calendar summary.
   * @param string $summary
   */
  public function setCalendarSummary($summary) {
    $this->calendarSummary = $summary;
  }

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $detailElement = $dom->createElement('actordetail');
    $detailElement->setAttribute('lang', $this->language);

    $titleElement = $dom->createElement('title');
    $titleElement->appendChild($dom->createTextNode($this->title));
    $detailElement->appendChild($titleElement);

    if ($this->calendarSummary) {
      $detailElement->appendChild($dom->createTextNode($this->calendarSummary));
    }

    if (count($this->media) > 0) {
      $this->media->appendToDOM($detailElement);
    }

    if (!empty($this->shortDescription)) {
      $descriptionElement = $dom->createElement('shortdescription');
      $descriptionElement->appendChild($dom->createTextNode($this->shortDescription));
      $detailElement->appendChild($descriptionElement);
    }

    if (!empty($this->longDescription)) {
      $descriptionElement = $dom->createElement('longdescription');
      $descriptionElement->appendChild($dom->createTextNode($this->longDescription));
      $detailElement->appendChild($descriptionElement);
    }

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

    if (!empty($xmlElement->calendarsummary)) {
      $actorDetail->setCalendarSummary((string)$xmlElement->calendarsummary);
    }

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
