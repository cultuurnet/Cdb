<?php

/**
 * @class
 * Representation of a keyword element in the cdb xml.
 */
class CultureFeed_Cdb_Data_Keyword implements CultureFeed_Cdb_IElement
{

    /**
     * Keyword value.
     * @var string
     */
    protected $value;

    /**
     * Keyword visibility.
     * @var bool
     */
    protected $visible;

    /**
     * Construct a new keyword.
     *
     * @param $value
     *   The keyword value.
     * @param $visible
     *   The keyword visibility.
     */
    public function __construct($value, $visible = true)
    {
        $this->value = $value;
        $this->visible = $visible;
    }

    /**
     * Get the value of the keyword.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get the visibility of the keyword.
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * Set the value of the keyword.
     *
     * @param string $value
     *   The keyword value.
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Set the visibility of the keyword.
     *
     * @param bool $visible
     *   The keyword visibility.
     */
    public function setVisibility($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMElement $element)
    {

        $dom = $element->ownerDocument;

        $keywordElement = $dom->createElement('keyword');
        $keywordElement->appendChild($dom->createTextNode($this->value));
        if (!$this->visible) {
            $keywordElement->setAttribute('visible', 'false');
        }

        $element->appendChild($keywordElement);

    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
     * @return CultureFeed_Cdb_Data_Keyword
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {

        $attributes = $xmlElement->attributes();
        if (!isset($attributes['visible'])) {
            $attributes['visible'] = true;
        }

        return new CultureFeed_Cdb_Data_Keyword((string) $xmlElement, $attributes['visible']);

    }
}
