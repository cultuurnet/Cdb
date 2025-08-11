<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_Address_PhysicalAddress implements CultureFeed_Cdb_IElement
{
    private ?string $street = null;
    private ?string $houseNumber = null;
    private string $city;
    private string $zip;
    private string $country;
    private ?CultureFeed_Cdb_Data_Address_GeoInformation $gis = null;

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getHouseNumber(): ?string
    {
        return $this->houseNumber;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getGeoInformation(): ?CultureFeed_Cdb_Data_Address_GeoInformation
    {
        return $this->gis;
    }

    public function setStreet(string $street): void
    {
        $this->street = trim($street);
    }

    public function setHouseNumber(string $houseNumber): void
    {
        $this->houseNumber = trim($houseNumber);
    }

    public function setCity(string $city): void
    {
        $this->city = trim($city);
    }

    public function setZip(string $zip): void
    {
        $this->zip = trim($zip);
    }

    public function setCountry(string $country): void
    {
        $this->country = trim($country);
    }

    public function setGeoInformation(CultureFeed_Cdb_Data_Address_GeoInformation $gis): void
    {
        $this->gis = $gis;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $physicalElement = $dom->createElement('physical');
        $physicalElement->appendChild($dom->createElement('city', $this->city));
        $physicalElement->appendChild(
            $dom->createElement('country', $this->country)
        );
        if ($this->gis) {
            $this->gis->appendToDOM($physicalElement);
        }
        if ($this->houseNumber) {
            $physicalElement->appendChild(
                $dom->createElement('housenr', $this->houseNumber)
            );
        }
        if ($this->street) {
            $physicalElement->appendChild(
                $dom->createElement('street', $this->street)
            );
        }
        $physicalElement->appendChild(
            $dom->createElement('zipcode', $this->zip)
        );

        $element->appendChild($physicalElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Address_PhysicalAddress
    {
        if (empty($xmlElement->city)) {
            throw new CultureFeed_Cdb_ParseException(
                'City is missing for physical address'
            );
        }

        if (empty($xmlElement->country)) {
            throw new CultureFeed_Cdb_ParseException(
                'Country is missing for physical address'
            );
        }

        if (empty($xmlElement->zipcode)) {
            throw new CultureFeed_Cdb_ParseException(
                'Zip code is missing for physical address'
            );
        }

        $physicalAddress = new CultureFeed_Cdb_Data_Address_PhysicalAddress();

        $physicalAddress->setCity((string) $xmlElement->city);
        $physicalAddress->setZip((string) $xmlElement->zipcode);
        $physicalAddress->setCountry((string) $xmlElement->country);

        if (!empty($xmlElement->street)) {
            $physicalAddress->setStreet((string) $xmlElement->street);
        }

        if (!empty($xmlElement->housenr)) {
            $physicalAddress->setHouseNumber((string) $xmlElement->housenr);
        }

        if (!empty($xmlElement->gis)) {
            $physicalAddress->setGeoInformation(
                CultureFeed_Cdb_Data_Address_GeoInformation::parseFromCdbXml(
                    $xmlElement->gis
                )
            );
        }

        return $physicalAddress;
    }
}
