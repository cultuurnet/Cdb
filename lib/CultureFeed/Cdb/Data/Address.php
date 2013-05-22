<?php

/**
 * @class
 * Representation of an address element in the cdb xml.
 */
class CultureFeed_Cdb_Data_Address implements CultureFeed_Cdb_IElement {

  /**
   * Physical address.
   * @var CultureFeed_Cdb_Data_Address_PhysicalAddress
   */
  protected $physicalAddress;

  /**
   * Virtual address.
   * @var CultureFeed_Cdb_Data_Address_VirtualAddress
   */
  protected $virtualAddress;

  /**
   * Label for this address.
   * @var string
   */
  protected $label;

  /**
   * Construct a new address.
   * @param CultureFeed_Cdb_Data_Address_PhysicalAddress $physical
   *   Physical address.
   * @param CultureFeed_Cdb_Data_Address_VirtualAddress $virtual
   *   Virtual address.
   */
  public function __construct(CultureFeed_Cdb_Data_Address_PhysicalAddress $physical = NULL, CultureFeed_Cdb_Data_Address_VirtualAddress $virtual = NULL) {
    $this->physicalAddress = $physical;
    $this->virtualAddress = $virtual;
  }

  /**
   * Get the physical address.
   * @return CultureFeed_Cdb_Data_Address_PhysicalAddress
   */
  public function getPhysicalAddress() {
    return $this->physicalAddress;
  }

  /**
   * Get the virtual address.
   * @return CultureFeed_Cdb_Data_Address_VirtualAddress
   */
  public function getVirtualAddress() {
    return $this->virtualAddress;
  }

  /**
   * Get the label.
   */
  public function getLabel() {
    return $this->label;
  }

  /**
   * Set the physical address
   * @param CultureFeed_Cdb_Data_Address_PhysicalAddress $address
   *   Address to set.
   */
  public function setPhysicalAddress(CultureFeed_Cdb_Data_Address_PhysicalAddress $address) {
    $this->physicalAddress = $address;
  }

  /**
   * Set the virtual address.
   * @param CultureFeed_Cdb_Data_Address_VirtualAddress $address
   *   Address to set.
   */
  public function setVirtualAddress(CultureFeed_Cdb_Data_Address_VirtualAddress $address) {
    $this->virtualAddress = $address;
  }

  /**
   * Set the label of this address.
   * @param string $label
   *   Label to set.
   */
  public function setLabel($label) {
    $this->label = $label;
  }

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMELement $element) {

    $dom = $element->ownerDocument;

    $addressElement = $dom->createElement('address');
    $element->appendChild($addressElement);

    if ($this->physicalAddress) {
      $this->physicalAddress->appendToDOM($addressElement);
    }

    if ($this->virtualAddress) {
      $this->virtualAddress->appendToDOM($addressElement);
    }

  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return CultureFeed_Cdb_Data_Address
   *
   * @throws Exception
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    $address = new CultureFeed_Cdb_Data_Address();
    if (!empty($xmlElement->physical)) {
      $address->setPhysicalAddress(CultureFeed_Cdb_Data_Address_PhysicalAddress::parseFromCdbXml($xmlElement->physical));
    }

    /*if (!empty($xmlElement->virtual)) {
      $address->setVirtualAddress(CultureFeed_Cdb_Data_Address_VirtualAddress::parseFromCdbXml($xmlElement->virtual));
    }*/

    if (!empty($xmlElement->label)) {
      $address->setLabel((string)$xmlElement->label);
    }

    return $address;

  }

}
