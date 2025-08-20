<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_Calendar_OpeningTime implements CultureFeed_Cdb_IElement
{
    private string $openFrom;
    private ?string $openTill = null;

    public function __construct(string $openFrom, string $openTill = null)
    {
        $this->setOpenFrom($openFrom);

        if ($openTill) {
            $this->setOpenTill($openTill);
        }
    }

    public function getOpenFrom(): string
    {
        return $this->openFrom;
    }

    public function getOpenTill(): ?string
    {
        return $this->openTill;
    }

    public function setOpenFrom(string $openFrom): void
    {
        CultureFeed_Cdb_Data_Calendar::validateTime($openFrom);
        $this->openFrom = $openFrom;
    }

    public function setOpenTill(string $openTill): void
    {
        CultureFeed_Cdb_Data_Calendar::validateTime($openTill);
        $this->openTill = $openTill;
    }

    public function appendToDOM(DOMELement $element): void
    {
        $dom = $element->ownerDocument;

        $openingElement = $dom->createElement('openingtime');
        $openingElement->setAttribute('from', $this->openFrom);
        if ($this->openTill) {
            $openingElement->setAttribute('to', $this->openTill);
        }

        $element->appendChild($openingElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Calendar_OpeningTime
    {
        $attributes = $xmlElement->attributes();
        if (!isset($attributes['from']) || empty($attributes['from'])) {
            $openFrom = '00:00:00';
        } else {
            $openFrom = (string) $attributes['from'];
        }

        $openTill = null;
        if (isset($attributes['to'])) {
            $openTill = (string) $attributes['to'];
        }

        return new CultureFeed_Cdb_Data_Calendar_OpeningTime(
            $openFrom,
            $openTill
        );
    }
}
