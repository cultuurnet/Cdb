<?php

/**
 * @class
 * Representation of a price element in the cdb xml.
 */
class CultureFeed_Cdb_Data_Price implements CultureFeed_Cdb_IElement {

  /**
   * The total price.
   * @var float
   */
  protected $value;

  /**
   * The description from this price.
   * @var string
   */
  protected $description;

  /**
   * Construct the proice object.
   * @param float $value
   *   The total value.
   */
  public function __construct($value) {
    $this->value = $value;
  }

  /**
   * Get the price value.
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * Set the value.
   * @param float $value
   *   Value to set.
   */
  public function setValue($value) {
    $this->value = $value;
  }

  /**
   * Get the description
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Set the description.
   * @param string $description
   *   Description to set.
   */
  public function setDescription($description) {
    $this->description = $description;
  }

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMELement $element) {

    $dom = $element->ownerDocument;

    $priceElement = $dom->createElement('price');

    if ($this->value) {
      $valueElement = $dom->createElement('pricevalue');
      $valueElement->appendChild($dom->createTextNode($this->value));
      $priceElement->appendChild($valueElement);
    }

    if ($this->description) {
      $descriptionElement = $dom->createElement('pricedescription');
      $descriptionElement->appendChild($dom->createTextNode($this->description));
      $priceElement->appendChild($descriptionElement);
    }

    $element->appendChild($priceElement);

  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return CultureFeed_Cdb_Data_Price
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    if (!isset($xmlElement->pricevalue) ) {
      throw new CultureFeed_ParseException("Value missing for price element");
    }

    $price = new CultureFeed_Cdb_Data_Price((string)$xmlElement->pricevalue);

    if (!empty($xmlElement->pricedescription)) {
      $price->setDescription((string)$xmlElement->pricedescription);
    }

    return $price;

  }

}
