<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_Performer implements CultureFeed_Cdb_IElement
{
    private ?string $label;
    private ?string $role;
    private CultureFeed_Cdb_Item_Actor $actor;

    public function __construct(string $role = null, string $label = null)
    {
        $this->role = $role;
        $this->label = $label;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function getActor(): CultureFeed_Cdb_Item_Actor
    {
        return $this->actor;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setActor(CultureFeed_Cdb_Item_Actor $actor): void
    {
        $this->actor = $actor;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $performerElement = $dom->createElement('performer');

        if ($this->role) {
            $roleElement = $dom->createElement('role');
            $roleElement->appendChild($dom->createTextNode($this->role));
            $performerElement->appendChild($roleElement);
        }

        $labelElement = $dom->createElement('label');
        $labelElement->appendChild($dom->createTextNode($this->label));
        $performerElement->appendChild($labelElement);

        $element->appendChild($performerElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Performer
    {
        $performer = new CultureFeed_Cdb_Data_Performer();

        if (!empty($xmlElement->label)) {
            $performer->setLabel((string) $xmlElement->label);
        }

        if (!empty($xmlElement->role)) {
            $performer->setRole((string) $xmlElement->role);
        }

        if (!empty($xmlElement->actor)) {
            $performer->setActor(
                CultureFeed_Cdb_Item_Actor::parseFromCdbXml($xmlElement->actor)
            );
        }

        return $performer;
    }
}
