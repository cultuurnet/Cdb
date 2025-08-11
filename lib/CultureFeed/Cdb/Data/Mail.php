<?php

final class CultureFeed_Cdb_Data_Mail implements CultureFeed_Cdb_IElement
{
    private string $address;
    private ?bool $main;
    private ?bool $reservation;

    public function __construct(string $address, bool $isMain = null, bool $forReservations = null)
    {
        $this->address = $address;
        $this->main = $isMain;
        $this->reservation = $forReservations;
    }

    public function isMainMail(): ?bool
    {
        return $this->main;
    }

    public function isForReservations(): ?bool
    {
        return $this->reservation;
    }

    /**
     * Get the mail address.
     */
    public function getMailAddress(): string
    {
        return $this->address;
    }

    public function setMain(bool $isMain): void
    {
        $this->main = $isMain;
    }

    public function setReservation(bool $forReservation): void
    {
        $this->reservation = $forReservation;
    }

    public function setMailAddress(string $address): void
    {
        $this->address = $address;
    }

    public function appendToDOM(DOMELement $element): void
    {
        $dom = $element->ownerDocument;

        $mailElement = $dom->createElement('mail', $this->address);

        if ($this->main) {
            $mailElement->setAttribute('main', 'true');
        }

        if ($this->reservation) {
            $mailElement->setAttribute('reservation', 'true');
        }

        $element->appendChild($mailElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Mail
    {
        $attributes = $xmlElement->attributes();
        $is_main = isset($attributes['main']) && $attributes['main'] == 'true';
        $for_reservations = isset($attributes['reservation']) && $attributes['reservation'] == 'true';

        return new CultureFeed_Cdb_Data_Mail(
            (string) $xmlElement,
            $is_main,
            $for_reservations
        );
    }
}
