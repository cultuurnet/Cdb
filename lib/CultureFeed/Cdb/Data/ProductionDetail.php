<?php

/**
 * @class
 * Representation of an ProductionDetail element in the cdb xml.
 */
class CultureFeed_Cdb_Data_ProductionDetail extends CultureFeed_Cdb_Data_Detail implements CultureFeed_Cdb_IElement {

  /**
   * @var string
   */
  protected $calendarSummary;

  /**
   * @var CultureFeed_Cdb_Data_PerformerList
   */
  protected $performers;

  /**
   * Constructor.
   */
  public function __construct() {
    $this->media = new CultureFeed_Cdb_Data_Media();
  }

  /**
   * Get the calendar summary.
   *
   * @return string
   */
  public function getCalendarSummary() {
    return $this->calendarSummary;
  }

  /**
   * Get the performers.
   *
   * @return CultureFeed_Cdb_Data_PerformersList
   */
  public function getPerformers() {
    return $this->performers;
  }

  /**
   * Set the calendar summary.
   *
   * @param string $summary
   */
  public function setCalendarSummary($summary) {
    $this->calendarSummary = $summary;
  }

  /**
   * Set the performers.
   *
   * @param CultureFeed_Cdb_Data_PerformersList $performers
   */
  public function setPerformers(CultureFeed_Cdb_Data_PerformerList $performers) {
    $this->performers = $performers;
  }

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $detailElement = $dom->createElement('productiondetail');
    $detailElement->setAttribute('lang', $this->language);

    if (!empty($this->longDescription)) {
      $descriptionElement = $dom->createElement('longdescription');
      $descriptionElement->appendChild($dom->createTextNode($this->longDescription));
      $detailElement->appendChild($descriptionElement);
    }

    if (count($this->media) > 0) {
      $this->media->appendToDOM($detailElement);
    }

    if (count($this->performers) > 0) {
      $this->performers->appendToDOM($detailElement);
    }

    if (!empty($this->price)) {
      $this->price->appendToDOM($detailElement);
    }

    if (!empty($this->shortDescription)) {
      $descriptionElement = $dom->createElement('shortdescription');
      $descriptionElement->appendChild($dom->createTextNode($this->shortDescription));
      $detailElement->appendChild($descriptionElement);
    }

    $titleElement = $dom->createElement('title');
    $titleElement->appendChild($dom->createTextNode($this->title));
    $detailElement->appendChild($titleElement);

    $element->appendChild($detailElement);

  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return CultureFeed_Cdb_Data_ProductionDetail
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    if (empty($xmlElement->title)) {
      throw new CultureFeed_ParseException("Title missing for productiondetail element");
    }

    $attributes = $xmlElement->attributes();
    if (empty($attributes['lang'])) {
      throw new CultureFeed_ParseException("Language (lang) missing for productiondetail element");
    }

    $productionDetail = new Culturefeed_Cdb_Data_ProductionDetail();
    $productionDetail->setTitle((string)$xmlElement->title);
    $productionDetail->setLanguage((string)$attributes['lang']);

    if (!empty($xmlElement->shortdescription)) {
      $productionDetail->setShortDescription((string)$xmlElement->shortdescription);
    }

    if (!empty($xmlElement->longdescription)) {
      $productionDetail->setLongDescription((string)$xmlElement->longdescription);
    }

    if (!empty($xmlElement->calendarsummary)) {
      $productionDetail->setCalendarSummary((string)$xmlElement->calendarsummary);
    }

    // Set Performers.
    if (!empty($xmlElement->performers)) {
      $productionDetail->setPerformers(CultureFeed_Cdb_Data_PerformerList::parseFromCdbXml($xmlElement->performers));
    }

    // Add the media files.
    if (!empty($xmlElement->media->file)) {
      foreach ($xmlElement->media->file as $fileElement) {
        $productionDetail->media->add(CultureFeed_Cdb_Data_File::parseFromCdbXML($fileElement));
      }
    }

    return $productionDetail;
  }
}
