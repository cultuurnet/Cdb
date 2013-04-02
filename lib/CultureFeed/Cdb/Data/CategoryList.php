<?php

/**
 * @class
 * Representation of a list of categories in the cdb xml.
 */
class CultureFeed_Cdb_Data_CategoryList implements CultureFeed_Cdb_IElement, Iterator {

  /**
   * Current position in the list.
   * @var int
   */
  protected $position = 0;

  /**
   * The list of categories.
   * @var array
   */
  protected $categories = array();

  /**
   * Add a new category to the list.
   * @param CultureFeed_Cdb_Data_Category $category
   *   Category to add.
   */
  public function add(CultureFeed_Cdb_Data_Category $category) {
    $this->categories[] = $category;
  }

  /**
   * @see Iterator::rewind()
   */
  function rewind() {
    $this->position = 0;
  }

  /**
   * @see Iterator::current()
   */
  function current() {
    return $this->categories[$this->position];
  }

  /**
   * @see Iterator::key()
   */
  function key() {
    return $this->position;
  }

  /**
   * @see Iterator::next()
   */
  function next() {
    ++$this->position;
  }

  /**
   * @see Iterator::valid()
   */
  function valid() {
    return isset($this->categories[$this->position]);
  }

  /**
   * Get all the categories from this list from a given type.
   * @param $type string
   *   Type of categories to get.
   */
  public function getCategoriesByType($type) {

    $categories = array();
    foreach ($this->categories as $category) {
      if ($category->getType() == $type) {
        $categories[] = $category;
      }
    }

    return $categories;

  }


  /**
   * Does the given category id exists in this list.
   *
   * @param string $id
   *   Category id. Ex 0.57.0.0.0
   * @return bool
   */
  function hasCategory($id) {

    foreach ($this->categories as $category) {
      if ($category->getId() == $id) {
        return TRUE;
      }
    }

    return FALSE;

  }

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $categoriesElement = $dom->createElement('categories');
    foreach ($this as $category) {
      $category->appendToDom($categoriesElement);
    }

    $element->appendChild($categoriesElement);

  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return CultureFeed_Cdb_Data_CategoryList
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    $categoryList = new CultureFeed_Cdb_Data_CategoryList();

    if (!empty($xmlElement->category)) {
      foreach ($xmlElement->category as $categoryElement) {
        $categoryList->add(CultureFeed_Cdb_Data_Category::parseFromCdbXml($categoryElement));
      }
    }

    return $categoryList;

  }

}
