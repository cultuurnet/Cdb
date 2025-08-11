<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_Price implements CultureFeed_Cdb_IElement
{
    private ?float $value;
    private ?string $description = null;
    private ?string $title = null;

    public function __construct(float $value = null)
    {
        $this->value = $value;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(?float $value): void
    {
        $this->value = $value;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function appendToDOM(DOMELement $element): void
    {
        $dom = $element->ownerDocument;

        $priceElement = $dom->createElement('price');

        if (isset($this->title)) {
            $titleElement = $dom->createElement('title');
            $titleElement->appendChild($dom->createTextNode($this->title));
            $priceElement->appendChild($titleElement);
        }

        if (isset($this->value)) {
            $valueElement = $dom->createElement('pricevalue');
            $valueElement->appendChild($dom->createTextNode((string) $this->value));
            $priceElement->appendChild($valueElement);
        }

        if ($this->description) {
            $descriptionElement = $dom->createElement('pricedescription');
            $descriptionElement->appendChild(
                $dom->createTextNode($this->description)
            );
            $priceElement->appendChild($descriptionElement);
        }

        $element->appendChild($priceElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Price
    {
        $value = !empty($xmlElement->pricevalue) ? (float) $xmlElement->pricevalue : null;
        $price = new CultureFeed_Cdb_Data_Price($value);

        if (!empty($xmlElement->pricedescription)) {
            $price->setDescription((string) $xmlElement->pricedescription);
        }

        if (!empty($xmlElement->title)) {
            $price->setTitle((string) $xmlElement->title);
        }

        return $price;
    }
}
