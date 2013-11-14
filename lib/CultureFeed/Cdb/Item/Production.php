<?php

class CultureFeed_Cdb_Item_Production extends CultureFeed_Cdb_Item_Base
        implements CultureFeed_Cdb_IElement {

  /**
   * Minimum age for the production.
   * @var int
   */
  protected $ageFrom;

  /**
   * Get the minimum age for this production.
   */
  public function getAgeFrom() {
    return $this->ageFrom;
  }

  /**
   * Set the minimum age for this production.
   * @param int $age
   *   Minimum age.
   *
   * @throws UnexpectedValueException
   */
  public function setAgeFrom($age) {

    if (!is_numeric($age)) {
      throw new UnexpectedValueException('Invalid age: ' . $age);
    }

    $this->ageFrom = $age;

  }

  /**
   * Appends the current object to the passed DOM tree.
   *
   * @param DOMElement $element
   *   The DOM tree to append to.
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $productionElement = $dom->createElement('production');

    if ($this->ageFrom) {
      $productionElement->appendChild($dom->createElement('agefrom', $this->ageFrom));
    }

    if ($this->cdbId) {
      $productionElement->setAttribute('cdbid', $this->cdbId);
    }

    if ($this->externalId) {
      $productionElement->setAttribute('externalid', $this->externalId);
    }

    if ($this->categories) {
      $this->categories->appendToDOM($productionElement);
    }

    if ($this->details) {
      $this->details->appendToDOM($productionElement);
    }
    
    if (count($this->keywords) > 0) {
      $keywordElement = $dom->createElement('keywords');
      $keywordElement->appendChild($dom->createTextNode(implode(';', $this->keywords)));
      $productionElement->appendChild($keywordElement);
    }
    
    if (!empty($this->relations)) {

      $relationsElement = $dom->createElement('eventrelations');

      foreach ($this->relations as $relation) {
        $relationElement = $dom->createElement('relatedproduction');
        $relationElement->appendChild($dom->createTextNode($relation->getTitle()));
        $relationElement->setAttribute('cdbid', $relation->getCdbid());
        $relationElement->setAttribute('externalid', $relation->getExternalId());
        $relationsElement->appendChild($relationElement);
      }

      $productionElement->appendChild($relationsElement);

    }

    $element->appendChild($productionElement);
  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   *
   * @return CultureFeed_Cdb_Item_Production
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    if (empty($xmlElement->categories)) {
      throw new CultureFeed_ParseException('Categories are required for production element');
    }

    if (empty($xmlElement->productiondetails)) {
      throw new CultureFeed_ParseException('Production details are required for production element');
    }

    $attributes = $xmlElement->attributes();
    $production = new CultureFeed_Cdb_Item_Production();

    // Set ID.
    if (isset($attributes['cdbid'])) {
      $production->setCdbId((string)$attributes['cdbid']);
    }

    if (isset($attributes['externalid'])) {
      $production->setExternalId((string)$attributes['externalid']);
    }

    if (!empty($xmlElement->agefrom)) {
      $production->setAgeFrom((int)$xmlElement->agefrom);
    }

    // Set categories
    $production->setCategories(CultureFeed_Cdb_Data_CategoryList::parseFromCdbXml($xmlElement->categories));

    // Set production details.
    $production->setDetails(CultureFeed_Cdb_Data_ProductionDetailList::parseFromCdbXml($xmlElement->productiondetails));

    // Set the related events for this production.
    if (!empty($xmlElement->relatedevents) && !empty($xmlElement->relatedevents->id)) {

      foreach ($xmlElement->relatedevents->id as $relatedItem) {

        $attributes = $relatedItem->attributes();

        $production->addRelation(new CultureFeed_Cdb_Item_Reference(
        	  (string)$attributes['cdbid']));

      }

    }

    // Set the keywords.
    if (!empty($xmlElement->keywords)) {
      $keywords = explode(';', $xmlElement->keywords);
      foreach ($keywords as $keyword) {
        $production->addKeyword($keyword);
      }
    }

    return $production;

  }

}
