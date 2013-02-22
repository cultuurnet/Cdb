<?php

class CultureFeed_Cdb_Item_Production implements CultureFeed_Cdb_IElement {

  /**
   * Cdbid from the production.
   * @var string
   */
  protected $cdbId;

  /**
   * External id from the production.
   * @var string
   */
  protected $externalId;

  /**
   * Title from the production
   * @var string
   */
  protected $title;

  /**
   * Set the cdbid from this production.
   * @param string $id cdbid to set
   */
  public function setCdbId($id) {
    $this->cdbId = $id;
  }

  /**
   * Get the cdbid from this event.
   * @return string
   */
  public function getCdbId() {
    return $this->cdbId;
  }

  /**
   * Set the external id from this production.
   * @param string $id id to set
   */
  public function setExternalId($id) {
    $this->externalId = $id;
  }

  /**
   * Get the external id from this production.
   * @return string
   */
  public function getExternalId() {
    return $this->externalId;
  }

  /**
   * Set the title from this production.
   * @param string $title Title to set.
   */
  public function setTitle($title) {
    $this->title = $title;
  }

  /**
   * Get the title from this production.
   */
  public function getTitle() {
    return $this->title;
  }

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
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return CultureFeed_Cdb_Item_Production
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {
    // TODO: Implement parseFromCdbXml() method.
  }

}
