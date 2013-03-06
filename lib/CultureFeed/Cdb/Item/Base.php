<?php

/**
 * @class
 * Abstract base class for the representation of an item on the culturefeed.
 */
abstract class CultureFeed_Cdb_Item_Base {

  /**
   * External id from an item.
   *
   * @var string
   */
  protected $externalId;

  /**
   * @var string
   */
  protected $cdbId;

  /**
   * Keywords from the item
   * @var array List with keywords.
   */
  protected $keywords;

/**
   * Categories from the items.
   * @var CultureFeed_Cdb_Data_CategoryList
   */
  protected $categories;

  /**
   * Relations from this item.
   * @var array List with related items.
   */
  protected $relations;

  /**
   * Get the external ID from this event.
   */
  public function getExternalId() {
    return $this->externalId;
  }

  /**
   * @return string
   */
  public function getCdbId() {
      return $this->cdbId;
  }

  /**
   * Get the categories from this item.
   */
  public function getCategories() {
    return $this->categories;
  }

  /**
   * Get the keywords from this item.
   */
  public function getKeywords() {
    return $this->keywords;
  }

  /**
   * Set the external id from this item.
   * @param string $id
   *   ID to set.
   */
  public function setExternalId($id) {
    $this->externalId = $id;
  }

  /**
   * Set the cdbid from this item.
   * @param string $id
   */
  public function setCdbId($id) {
    $this->cdbId = $id;
  }

  /**
   * Set the categories from this event.
   * @param CultureFeed_Cdb_Data_CategoryList $categories
   *   Categories to set.
   */
  public function setCategories(CultureFeed_Cdb_Data_CategoryList $categories) {
    $this->categories = $categories;
  }

  /**
   * Add a keyword to this event.
   * @param string $keyword
   *   Add a keyword.
   */
  public function addKeyword($keyword) {
    $this->keywords[$keyword] = $keyword;
  }

  /**
   * Delete a keyword from this event.
   * @param string $keyword
   *   Keyword to remove.
   */
  public function deleteKeyword($keyword) {

    if (!isset($this->keywords[$keyword])) {
      throw new Exception('Trying to remove a non-existing keyword.');
    }

    unset($this->keywords[$keyword]);

  }

  /**
   * Add a relation to the current item.
   * @param CultureFeed_Cdb_Item_Base $item
   */
  public function addRelation(CultureFeed_Cdb_Item_Reference $item) {
    $this->relations[$item->getCdbId()] = $item;
  }

  /**
   * Delete a relation from the event.
   * @param string $cdbid Cdbid to delete
   */
  public function deleteRelation($cdbid) {

    if (!isset($this->relations[$cdbid])) {
      throw new Exception('Trying to remove a non-existing relation.');
    }

    unset($this->relations[$cdbid]);

  }

}
