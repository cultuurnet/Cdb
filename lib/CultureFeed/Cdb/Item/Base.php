<?php

/**
 * @class
 * Abstract base class for the representation of an item on the culturefeed.
 */
abstract class CultureFeed_Cdb_Item_Base {

  /**
   * External id from the item.
   *
   * @var string
   */
  protected $externalId;

  /**
   * cdbId from the item.
   * @var string
   */
  protected $cdbId;

  /**
   * Categories from the item.
   * @var CultureFeed_Cdb_Data_CategoryList
   */
  protected $categories;

  /**
   * Details from the item.
   *
   * @var CultureFeed_Cdb_Data_DetailList
   */
  protected $details;

  /**
   * Keywords from the item
   * @var array List with keywords.
   */
  protected $keywords;

  /**
   * Relations from the item.
   * @var array List with related items.
   */
  protected $relations;

  /**
   * Get the external ID from this item.
   */
  public function getExternalId() {
    return $this->externalId;
  }

  /**
   * Get the Cdbid from this item.
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
   * Get the details from this item.
   *
   * @return CultureFeed_Cdb_Data_DetailList
   */
  public function getDetails() {
    return $this->details;
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
   * Set the categories from this item.
   * @param CultureFeed_Cdb_Data_CategoryList $categories
   *   Categories to set.
   */
  public function setCategories(CultureFeed_Cdb_Data_CategoryList $categories) {
    $this->categories = $categories;
  }

  /**
   * Set the details from this item.
   * @param CultureFeed_Cdb_Data_DetailList $details
   *   Detail information from the current item.
   */
  public function setDetails(CultureFeed_Cdb_Data_DetailList $details) {
    $this->details = $details;
  }

  /**
   * Add a keyword to this item.
   * @param string $keyword
   *   Add a keyword.
   */
  public function addKeyword($keyword) {
    $this->keywords[$keyword] = $keyword;
  }

  /**
   * Delete a keyword from this item.
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
   * Delete a relation from the item.
   * @param string $cdbid Cdbid to delete
   */
  public function deleteRelation($cdbid) {

    if (!isset($this->relations[$cdbid])) {
      throw new Exception('Trying to remove a non-existing relation.');
    }

    unset($this->relations[$cdbid]);

  }

  /**
   * Get the details for a given language.
   * @param string $language_code
   *   Language code to get.
   *
   * @return CultureFeed_Cdb_Data_Detail|NULL
   */
  public function getDetailByLanguage($language_code) {
    /* @var CultureFeed_Cdb_Data_ActorDetail $detail */
    foreach ($this->details as $detail) {
      if ($language_code == $detail->getLanguage()) {
        return $detail;
      }
    }
  }

}
