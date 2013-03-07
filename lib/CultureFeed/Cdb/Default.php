<?php

/**
 * @class
 * Representation of the cdb xml on the culturefeed.
 */
class CultureFeed_Cdb_Default {

  /**
   * Url to the cdb xml scheme.
   */
  const CDB_SCHEME_URL = 'http://www.cultuurdatabank.com/XMLSchema/CdbXSD/3.1/FINAL';

  /**
   * Name from the xml scheme.
   */
  const CDB_SCHEME_NAME = 'cdbxml';

  /**
   * List of items to be placed in the CdbXml.
   * @var array
   */
  private $items = array();

  /**
   * Add an item from a  to the items list.
   * @param CultureFeed_Cdb_Item_Base $item
   *  Item to add
   * @throws Exception.
   */
  public function addItem(CultureFeed_Cdb_Item_Base $item) {

    switch (get_class($item)) {

      case 'CultureFeed_Cdb_Item_Actor':
        $this->items['actors'][] = $item;
      break;

      case 'CultureFeed_Cdb_Item_Event':
        $this->items['events'][] = $item;
      break;

      case 'CultureFeed_Cdb_Item_Production':
        $this->items['productions'][] = $item;
      break;

      default:
        throw new Exception("Trying to add an unknown item type '$type'");

    }

  }

  /**
   * Print the Cdb.
   */
  public function __toString() {

    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;
    $dom->preserveWhiteSpace = false;

    $cdbElement = $dom->createElementNS(self::CDB_SCHEME_URL, self::CDB_SCHEME_NAME);
    $cdbElement->setAttributeNS('http://www.w3.org/2001/XMLSchema-instance', 'xsi:schemaLocation', self::CDB_SCHEME_URL .' ' . self::CDB_SCHEME_URL . '/CdbXSD.xsd');
    $dom->appendChild($cdbElement);

    foreach ($this->items as $type => $itemsFromType) {

      if ($itemsFromType) {
        $typeElement = $dom->createElement($type);
        $cdbElement->appendChild($typeElement);

        foreach ($itemsFromType as $item) {
          $item->appendToDOM($typeElement);
        }

      }

    }

    return $dom->saveXML();

  }

}