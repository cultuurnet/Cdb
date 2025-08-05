<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_Language implements CultureFeed_Cdb_IElement
{
    const TYPE_DUBBED = 'dubbed';
    const TYPE_SPOKEN = 'spoken';
    const TYPE_SUBTITLES = 'subtitles';

    private ?string $language;
    private ?string $type;

    public function __construct(string $language = null, string $type = null)
    {
        $this->language = $language;
        $this->type = $type;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $languageElement = $dom->createElement('language');
        $languageElement->appendChild($dom->createTextNode($this->language));

        if ($this->type) {
            $languageElement->setAttribute('type', $this->type);
        }

        $element->appendChild($languageElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Language
    {
        $language = new self((string) $xmlElement);

        $attributes = $xmlElement->attributes();

        if (isset($attributes['type'])) {
            $language->setType((string) $attributes['type']);
        }

        return $language;
    }
}
