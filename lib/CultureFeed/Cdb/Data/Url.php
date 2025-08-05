<?php declare(strict_types=1);

/**
 * @class
 * Representation of an url element in the cdb xml.
 */
final class CultureFeed_Cdb_Data_Url implements CultureFeed_Cdb_IElement
{
    private bool $main;
    private bool $reservation;
    private string $url;

    public function __construct(string $url, bool $isMain = false, bool $forReservations = false)
    {
        $this->url = $url;
        $this->main = $isMain;
        $this->reservation = $forReservations;
    }

    public function isMain(): bool
    {
        return $this->main;
    }

    public function isForReservations(): bool
    {
        return $this->reservation;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setMain(bool $isMain = true): void
    {
        $this->main = $isMain;
    }

    public function setReservation(bool $forReservation = true): void
    {
        $this->reservation = $forReservation;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function appendToDOM(DOMELement $element): void
    {
        $dom = $element->ownerDocument;

        $urlElement = $dom->createElement('url');
        $urlElement->appendChild($dom->createTextNode($this->url));

        if ($this->main) {
            $urlElement->setAttribute('main', 'true');
        }

        if ($this->reservation) {
            $urlElement->setAttribute('reservation', 'true');
        }

        $element->appendChild($urlElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Url
    {
        $attributes = $xmlElement->attributes();
        $is_main = isset($attributes['main']) && $attributes['main'] == 'true';
        $for_reservations = isset($attributes['reservation']) && $attributes['reservation'] == 'true';

        return new CultureFeed_Cdb_Data_Url(
            (string) $xmlElement,
            $is_main,
            $for_reservations
        );
    }
}
