<?php declare(strict_types=1);

final class CultureFeed_Cdb_Data_Address_VirtualAddress implements CultureFeed_Cdb_IElement
{
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $virtualElement = $dom->createElement('virtual');
        $virtualElement->appendChild(
            $dom->createElement('title', $this->title)
        );

        $element->appendChild($virtualElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Address_VirtualAddress
    {
        if (empty($xmlElement->title)) {
            throw new CultureFeed_Cdb_ParseException(
                'Title is missing for virtual address'
            );
        }

        return new self((string) $xmlElement->title);
    }
}
