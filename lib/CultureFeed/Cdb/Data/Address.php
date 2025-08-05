<?php declare(strict_types=1);

final class CultureFeed_Cdb_Data_Address implements CultureFeed_Cdb_IElement
{
    private ?CultureFeed_Cdb_Data_Address_PhysicalAddress $physicalAddress = null;
    private ?CultureFeed_Cdb_Data_Address_VirtualAddress $virtualAddress = null;
    private ?string $label = null;

    public function __construct(CultureFeed_Cdb_Data_Address_PhysicalAddress $physical = null, CultureFeed_Cdb_Data_Address_VirtualAddress $virtual = null)
    {
        $this->physicalAddress = $physical;
        $this->virtualAddress = $virtual;
    }

    public function getPhysicalAddress(): ?CultureFeed_Cdb_Data_Address_PhysicalAddress
    {
        return $this->physicalAddress;
    }

    public function getVirtualAddress(): ?CultureFeed_Cdb_Data_Address_VirtualAddress
    {
        return $this->virtualAddress;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setPhysicalAddress(CultureFeed_Cdb_Data_Address_PhysicalAddress $address): void
    {
        $this->physicalAddress = $address;
    }

    public function setVirtualAddress(CultureFeed_Cdb_Data_Address_VirtualAddress $address): void
    {
        $this->virtualAddress = $address;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function appendToDOM(DOMELement $element): void
    {
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
     * @throws Exception
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Address
    {
        $address = new CultureFeed_Cdb_Data_Address();
        if (!empty($xmlElement->physical)) {
            $address->setPhysicalAddress(
                CultureFeed_Cdb_Data_Address_PhysicalAddress::parseFromCdbXml(
                    $xmlElement->physical
                )
            );
        }

        if (!empty($xmlElement->virtual)) {
            $address->setVirtualAddress(
                CultureFeed_Cdb_Data_Address_VirtualAddress::parseFromCdbXml(
                    $xmlElement->virtual
                )
            );
        }

        if (!empty($xmlElement->label)) {
            $address->setLabel((string) $xmlElement->label);
        }

        return $address;
    }
}
