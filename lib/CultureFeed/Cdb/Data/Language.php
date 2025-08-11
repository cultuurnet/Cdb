<?php

/**
 * @file
 */
class CultureFeed_Cdb_Data_Language implements CultureFeed_Cdb_IElement
{
    const TYPE_DUBBED = 'dubbed';
    const TYPE_SPOKEN = 'spoken';
    const TYPE_SUBTITLES = 'subtitles';

    /**
     * @var string
     */
    protected $type;

    protected $language;

    public function __construct($language = null, $type = null)
    {
        $this->language = $language;
        $this->type = $type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage()
    {
        return $this->language;
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMElement $element)
    {

        $dom = $element->ownerDocument;

        $languageElement = $dom->createElement('language');
        $languageElement->appendChild($dom->createTextNode($this->language));

        if ($this->type) {
            $languageElement->setAttribute('type', $this->type);
        }

        $element->appendChild($languageElement);
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_Language
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {

        $language = new self((string) $xmlElement);

        $attributes = $xmlElement->attributes();

        if (isset($attributes['type'])) {
            $language->setType((string) $attributes['type']);
        }

        return $language;
    }
}
