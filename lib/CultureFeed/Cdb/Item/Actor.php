<?php

/**
 * @class
 * Representation of an actor on the culturefeed.
 */
class CultureFeed_Cdb_Item_Actor extends CultureFeed_Cdb_Item_Base implements CultureFeed_Cdb_IElement {

  /**
   * Is the actor object centrally guarded for uniqueness
   * @var bool
   */
  protected $asset;

  /**
   * @var CultureFeed_Cdb_Data_ActorDetailList
   */
  protected $details;

  /**
   * Contact info for an actor.
   *
   * @var CultureFeed_Cdb_Data_ContactInfo
   */
  protected $contactInfo;

  /**
   * Week scheme for the opening times from the actor.
   * @var CultureFeed_Cdb_Data_Calendar_WeekScheme
   */
  protected $weekScheme;

  /**
   * Construct the actor.
   */
  public function __construct() {
    $this->details = new CultureFeed_Cdb_Data_ActorDetailList();
  }

  /**
   * Get the contact info of this actor.
   */
  public function getContactInfo() {
    return $this->contactInfo;
  }

  /**
   * Get the weekscheme of this actor.
   */
  public function getWeekScheme() {
    return $this->weekScheme;
  }

  /**
   * Set the contact info of this contact.
   * @param CultureFeed_Cdb_Data_Calendar $contactInfo
   *   Contact info to set.
   */
  public function setContactInfo(CultureFeed_Cdb_Data_ContactInfo $contactInfo) {
    $this->contactInfo = $contactInfo;
  }

  /**
   * Get the weekscheme of this actor.
   */
  public function setWeekScheme(CultureFeed_Cdb_Data_Calendar_Weekscheme $weekScheme) {
    $this->weekScheme = $weekScheme;
  }

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $actorElement = $dom->createElement('actor');

    if ($this->cdbId) {
      $actorElement->setAttribute('cdbid', $this->cdbId);
    }

    if ($this->externalId) {
      $actorElement->setAttribute('externalid', $this->externalId);
    }

    if ($this->details) {
      $this->details->appendToDOM($actorElement);
    }

    if ($this->categories) {
      $this->categories->appendToDOM($actorElement);
    }

    if ($this->contactInfo) {
      $this->contactInfo->appendToDOM($actorElement);
    }

    if (count($this->keywords) > 0) {
      $keywordElement = $dom->createElement('keywords');
      $keywordElement->appendChild($dom->createTextNode(implode(';', $this->keywords)));
      $actorElement->appendChild($keywordElement);
    }

    if ($this->weekScheme) {
      $this->weekScheme->appendToDOM($actorElement);
    }

    $element->appendChild($actorElement);

  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return CultureFeed_Cdb_Item_Actor
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    if (empty($xmlElement->categories)) {
      throw new CultureFeed_Cdb_ParseException('Categories missing for actor element');
    }

    if (empty($xmlElement->actordetails)) {
      throw new CultureFeed_Cdb_ParseException('Actordetails missing for actor element');
    }

    $actor = new self();

    $actor_attributes = $xmlElement->attributes();

    if (isset($actor_attributes['cdbid'])) {
      $actor->setCdbId((string)$actor_attributes['cdbid']);
    }

    if (isset($actor_attributes['externalid'])) {
      $actor->setExternalId((string)$actor_attributes['externalid']);
    }

    $actor->setDetails(CultureFeed_Cdb_Data_ActorDetailList::parseFromCdbXml($xmlElement->actordetails));

    // Set categories
    $actor->setCategories(CultureFeed_Cdb_Data_CategoryList::parseFromCdbXml($xmlElement->categories));

    // Set contact information.
    if (!empty($xmlElement->contactinfo)) {
      $actor->setContactInfo(CultureFeed_Cdb_Data_ContactInfo::parseFromCdbXml($xmlElement->contactinfo));
    }

    // Set the keywords.
    self::parseKeywords($xmlElement, $actor);

    // Set the weekscheme.
    if (!empty($xmlElement->weekscheme)) {
      $actor->setWeekScheme(CultureFeed_Cdb_Data_Calendar_Weekscheme::parseFromCdbXml($xmlElement->weekscheme));
    }

    return $actor;

  }

}
