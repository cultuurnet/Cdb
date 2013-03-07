<?php

/**
 * @class
 * Representation of a list of performers in the cdb xml.
 */
class CultureFeed_Cdb_Data_PerformerList implements CultureFeed_Cdb_IElement, Iterator {

  /**
   * Current position in the list.
   * @var int
   */
  protected $position = 0;

  /**
   * The list of performers.
   * @var array
   */
  protected $performers = array();

  /**
   * Add a new performer to the list.
   * @param CultureFeed_Cdb_Data_performer $performer
   *   performer to add.
   */
  public function add(CultureFeed_Cdb_Data_Performer $performer) {
    $this->performers[] = $performer;
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
    return $this->performers[$this->position];
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
    return isset($this->performers[$this->position]);
  }

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $performersElement = $dom->createElement('performers');
    foreach ($this as $performer) {
      $performer->appendToDom($performersElement);
    }

    $element->appendChild($performersElement);

  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return CultureFeed_Cdb_Data_PerformerList
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    $performerList = new CultureFeed_Cdb_Data_PerformerList();

    if (!empty($xmlElement->performer)) {
      foreach ($xmlElement->performer as $performerElement) {
        $performerList->add(CultureFeed_Cdb_Data_Performer::parseFromCdbXml($performerElement));
      }
    }

    return $performerList;

  }

}
  