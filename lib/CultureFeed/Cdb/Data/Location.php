<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_Location implements CultureFeed_Cdb_IElement
{
    private CultureFeed_Cdb_Data_Address $address;
    private string $label;
    private ?string $cdbid = null;
    private ?CultureFeed_Cdb_Item_Actor $actor = null;
    private ?string $externalId = null;

    public function __construct(CultureFeed_Cdb_Data_Address $address)
    {
        $this->address = $address;
    }

    public function getAddress(): CultureFeed_Cdb_Data_Address
    {
        return $this->address;
    }

    public function getCdbid(): ?string
    {
        return $this->cdbid;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getActor(): ?CultureFeed_Cdb_Item_Actor
    {
        return $this->actor;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setActor(CultureFeed_Cdb_Item_Actor $actor): void
    {
        $this->actor = $actor;
    }

    public function setAddress(CultureFeed_Cdb_Data_Address $address): void
    {
        $this->address = $address;
    }

    public function setCdbid(string $cdbid): void
    {
        $this->cdbid = $cdbid;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function appendToDOM(DOMELement $element): void
    {
        $dom = $element->ownerDocument;

        $locationElement = $dom->createElement('location');

        $this->address->appendToDOM($locationElement);

        if ($this->label) {
            $labelElement = $dom->createElement('label');
            $labelElement->appendChild($dom->createTextNode($this->label));
            if ($this->cdbid) {
                $labelElement->setAttribute('cdbid', $this->cdbid);
            }

            if ($this->externalId) {
                $labelElement->setAttribute('externalid', $this->externalId);
            }

            $locationElement->appendChild($labelElement);
        }

        if ($this->actor) {
            $this->actor->appendToDOM($locationElement);
        }

        $element->appendChild($locationElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Location
    {
        if (empty($xmlElement->address)) {
            throw new CultureFeed_Cdb_ParseException(
                'Address missing for location element'
            );
        }

        $address = CultureFeed_Cdb_Data_Address::parseFromCdbXml(
            $xmlElement->address
        );
        $location = new CultureFeed_Cdb_Data_Location($address);

        if (!empty($xmlElement->label)) {
            $attributes = $xmlElement->label->attributes();
            $location->setLabel((string) $xmlElement->label);

            if (isset($attributes['cdbid'])) {
                $location->setCdbid((string) $attributes['cdbid']);
            }

            if (isset($attributes['externalid'])) {
                $location->setExternalId((string) $attributes['externalid']);
            }
        }

        if (!empty($xmlElement->actor)) {
            $actor = CultureFeed_Cdb_Item_Actor::parseFromCdbXml(
                $xmlElement->actor
            );
            $location->setActor($actor);
        }

        return $location;
    }
}
