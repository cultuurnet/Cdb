<?php declare(strict_types=1);

final class CultureFeed_Cdb_Data_Keyword implements CultureFeed_Cdb_IElement
{
    private string $value;
    private bool $visible;

    public function __construct(string $value, bool $visible = true)
    {
        $this->value = $value;
        $this->visible = $visible;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function setVisibility(bool $visible): void
    {
        $this->visible = $visible;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $keywordElement = $dom->createElement('keyword');
        $keywordElement->appendChild($dom->createTextNode($this->value));
        if (!$this->visible) {
            $keywordElement->setAttribute('visible', 'false');
        }

        $element->appendChild($keywordElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Keyword
    {
        $attributes = $xmlElement->attributes();
        if (!isset($attributes['visible'])) {
            $attributes['visible'] = new SimpleXMLElement('true');
        }

        return new CultureFeed_Cdb_Data_Keyword(
            (string) $xmlElement,
            (bool )$attributes['visible']
        );
    }
}
