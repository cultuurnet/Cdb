<?php

/**
 * @class
 * Representation of a Detail element in the cdb xml.
 */
abstract class CultureFeed_Cdb_Data_Detail {

  /**
   * Title from the detail item.
   *
   * @var string
   */
  protected $title;

  /**
   * Short description from an item.
   *
   * @var string
   */
  protected $shortDescription;

  /**
   * @var string
   */
  protected $longDescription;

  /**
   * Language from current detail.
   * @var string
   */
  protected $language;

  /**
   * @var CultureFeed_Cdb_Data_Media
   */
  protected $media;

  /**
   * Price information from the item.
   * @var CultureFeed_Cdb_Data_Price
   */
  protected $price;

  /**
   * Get the title from current detail.
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * Get the short description from current detail.
   *
   * @return string
   */
  public function getShortDescription() {
    return $this->shortDescription;
  }

  /**
   * Get the long description from current detail.
   *
   * @return string
   */
  public function getLongDescription() {
    return $this->longDescription;
  }

  /**
   * Get the language from current detail.
   */
  public function getLanguage() {
    return $this->language;
  }

  /**
   * Get the list of media items from current detail.
   * 
   * @return CultureFeed_Cdb_Data_Media
   */
  public function getMedia() {
    return $this->media;
  }

  /**
   * Get the price information from current detail.
   *
   * @return CultureFeed_Cdb_Data_Price
   */
  public function getPrice() {
    return $this->price;
  }

  /**
   * Set the title from current detail.
   * @param $title
   *   Title to set.
   */
  public function setTitle($title) {
    $this->title = $title;
  }

  /**
   * Set the short description from current detail.
   */
  public function setShortDescription($description) {
    $this->shortDescription = $description;
  }

  /**
   * Set the long description from current detail.
   */
  public function setLongDescription($description) {
    $this->longDescription = $description;
  }

  /**
   * Get the language from current detail.
   */
  public function setLanguage($language) {
    $this->language = $language;
  }

  /**
   * Set the price information for current detail.
   * @param CultureFeed_Cdb_Data_Price $price
   */
  public function setPrice($price) {
    $this->price = $price;
  }

}
