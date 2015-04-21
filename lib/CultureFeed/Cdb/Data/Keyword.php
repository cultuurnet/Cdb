<?php

/**
 * @class
 * Representation of a keyword element in the cdb xml.
 */
class CultureFeed_Cdb_Data_Keyword implements CultureFeed_Cdb_IElement {

  /**
   * Keyword value.
   * @var string
   */
  protected $value;

  /**
   * Keyword visibility.
   * @var bool
   */
  protected $visibility;

  /**
   * Construct a new keyword.
   *
   * @param $value
   *   The keyword value.
   * @param $visibility
   *   The keyword visibility.
   */
  public function __construct($value, $visibility) {
    $this->value = $value;
    $this->visibility = $visibility;
  }

  /**
   * Get the value of the keyword.
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * Get the visibility of the keyword.
   */
  public function getVisibility() {
    return $this->visibility;
  }

  /**
   * Set the value of the keyword.
   *
   * @param string $value
   *   The keyword value.
   */
  public function setValue($value) {
    $this->value = $value;
  }

  /**
   * Set the visibility of the keyword.
   *
   * @param bool $visibility
   *   The keyword visibility.
   */
  public function setVisibility($visibility) {
    $this->visibility = $visibility;
  }

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $categoryElement = $dom->createElement('keyword');
    $categoryElement->appendChild($dom->createTextNode($this->value));
    $categoryElement->setAttribute('visibility', $this->visibility);

    $element->appendChild($categoryElement);

  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return CultureFeed_Cdb_Data_Keyword
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    $attributes = $xmlElement->attributes();
    if (!isset($attributes['visibility'])) {
      $attributes['visibility'] = TRUE;
    }

    return new CultureFeed_Cdb_Data_Keyword((string) $xmlElement, $attributes['visibility']);

  }

}
