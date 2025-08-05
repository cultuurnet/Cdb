<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_Phone implements CultureFeed_Cdb_IElement
{
    public const PHONE_TYPE_PHONE = 'phone';
    public const PHONE_TYPE_FAX = 'fax';

    private ?bool $main;
    private ?bool $reservation;
    private ?string $type;
    private string $number;

    public function __construct(string $number, string $type = null, bool $isMain = null, bool $forReservations = null)
    {
        $this->number = $number;
        $this->type = $type;
        $this->main = $isMain;
        $this->reservation = $forReservations;
    }

    public function isMainPhone(): ?bool
    {
        return $this->main;
    }

    public function isForReservations(): ?bool
    {
        return $this->reservation;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setMain(bool $isMain): void
    {
        $this->main = $isMain;
    }

    public function setReservation(bool $forReservation): void
    {
        $this->reservation = $forReservation;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function appendToDOM(DOMELement $element): void
    {
        $dom = $element->ownerDocument;

        $phoneElement = $dom->createElement('phone', $this->number);
        if ($this->type) {
            $phoneElement->setAttribute('type', $this->type);
        }

        if ($this->main) {
            $phoneElement->setAttribute('main', 'true');
        }

        if ($this->reservation) {
            $phoneElement->setAttribute('reservation', 'true');
        }

        $element->appendChild($phoneElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Phone
    {
        $attributes = $xmlElement->attributes();
        $is_main = isset($attributes['main']) && $attributes['main'] == 'true';
        $for_reservations = isset($attributes['reservation']) && $attributes['reservation'] == 'true';
        $type = isset($attributes['type']) ? (string) $attributes['type'] : null;

        return new CultureFeed_Cdb_Data_Phone(
            (string) $xmlElement,
            $type,
            $is_main,
            $for_reservations
        );
    }
}
