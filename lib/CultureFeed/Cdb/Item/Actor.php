<?php

class CultureFeed_Cdb_Item_Actor implements CultureFeed_Cdb_IElement {

  /**
   * @var CultureFeed_Cdb_Data_ActorDetailList
   */
  protected $details;

  /**
   * @var string
   */
  protected $cdbId;

  /**
   * @var CultureFeed_Cdb_Data_CategoryList
   */
  protected $categories;

  /**
   * Appends the current object to the passed DOM tree.
   *
   * @param DOMElement $element
   *   The DOM tree to append to.
   */
  public function appendToDOM(DOMElement $element) {
    // TODO: Implement appendToDOM() method.
  }

  /**
   * Parse a new object from a given cdbxml element.
   * @param CultureFeed_SimpleXMLElement $xmlElement
   *   XML to parse.
   * @throws CultureFeed_ParseException
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {
    $actor = new self();

    $actor_attributes = $xmlElement->attributes();

    if (isset($actor_attributes['cdbid'])) {
      $actor->setCdbId((string)$actor_attributes['cdbid']);
    }
    // Set categories
    $actor->setCategories(CultureFeed_Cdb_Data_CategoryList::parseFromCdbXml($xmlElement->categories));

    if (!empty($xmlElement->actordetails)) {
      $actor->setDetails(CultureFeed_Cdb_Data_ActorDetailList::parseFromCdbXml($xmlElement->actordetails));
    }
    else {
      $actor->setDetails(new CultureFeed_Cdb_Data_ActorDetailList());
    }

    return $actor;
  }

  /**
   * @param string $id
   */
  public function setCdbId($id) {
    $this->cdbId = $id;
  }

  /**
   * @return string
   */
  public function getCdbId() {
    return $this->cdbId;
  }

  /**
   * Set the details from this actor.
   * @param CultureFeed_Cdb_Data_ActorDetailList $details
   *   Detail information from the actor.
   */
  public function setDetails(CultureFeed_Cdb_Data_ActorDetailList $details) {
    $this->details = $details;
  }

  /**
   * Set the categories from this actor.
   * @param CultureFeed_Cdb_Data_CategoryList $categories
   *   Categories to set.
   */
  public function setCategories(CultureFeed_Cdb_Data_CategoryList $categories) {
    $this->categories = $categories;
  }

  /**
   * Get the details from this event.
   *
   * @return CultureFeed_Cdb_Data_ActorDetail[]
   */
  public function getDetails() {
    return $this->details;
  }

  /**
   * @param string $language_code
   *
   * @return CultureFeed_Cdb_Data_ActorDetail|NULL
   */
  public function getDetailByLanguage($language_code) {
    /* @var CultureFeed_Cdb_Data_ActorDetail $detail */
    foreach ($this->details as $detail) {
      if ($language_code == $detail->getLanguage()) {
        return $detail;
      }
    }
  }

  /**
   * Get the categories from this event.
   */
  public function getCategories() {
    return $this->categories;
  }
}
