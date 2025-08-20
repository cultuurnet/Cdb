<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_Organiser implements CultureFeed_Cdb_IElement
{
    private string $label;
    private ?string $cdbid = null;
    private ?CultureFeed_Cdb_Item_Actor $actor = null;
    private ?string $externalId = null;

    public function getCdbid(): ?string
    {
        return $this->cdbid;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setCdbid(string $cdbid): void
    {
        $this->cdbid = $cdbid;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function setActor(CultureFeed_Cdb_Item_Actor $actor): void
    {
        $this->actor = $actor;
    }

    public function getActor(): ?CultureFeed_Cdb_Item_Actor
    {
        return $this->actor;
    }

    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function appendToDOM(DOMELement $element): void
    {
        $dom = $element->ownerDocument;
        $organiserElement = $dom->createElement('organiser');

        if ($this->label) {
            $labelElement = $dom->createElement('label');
            $labelElement->appendChild($dom->createTextNode($this->label));
            if ($this->cdbid) {
                $labelElement->setAttribute('cdbid', $this->cdbid);
            }
            if ($this->externalId) {
                $labelElement->setAttribute('externalid', $this->externalId);
            }
            $organiserElement->appendChild($labelElement);
        }

        $element->appendChild($organiserElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Organiser
    {
        $organiser = new CultureFeed_Cdb_Data_Organiser();

        if (empty($xmlElement->label) && empty($xmlElement->actor)) {
            //throw new CultureFeed_Cdb_ParseException("One of the required fields (actor or label) is missing for organiser element");
        }

        if (!empty($xmlElement->label)) {
            $organiser->setLabel((string) $xmlElement->label);

            $attributes = $xmlElement->label->attributes();

            if (!empty($attributes->cdbid)) {
                $organiser->setCdbid((string) $attributes->cdbid);
            }

            if (!empty($attributes->externalid)) {
                $organiser->setExternalId((string) $attributes->externalId);
            }
        } elseif (!empty($xmlElement->actor)) {
            $actor = CultureFeed_Cdb_Item_Actor::parseFromCdbXml(
                $xmlElement->actor
            );
            $organiser->setActor($actor);
        }

        return $organiser;
    }
}
