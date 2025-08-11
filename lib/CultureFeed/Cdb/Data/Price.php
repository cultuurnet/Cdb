<?php

/**
 * @class
 * Representation of a price element in the cdb xml.
 */
class CultureFeed_Cdb_Data_Price implements CultureFeed_Cdb_IElement
{
    /**
     * The total price.
     * @var float|NULL
     */
    protected $value;

    /**
     * The description from this price.
     * @var string
     */
    protected $description;

    /**
     * @var string|null
     */
    protected $title;

    /**
     * Construct the price object.
     *
     * @param float|NULL $value
     *   The total value.
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * Get the price value.
     *
     * @return float|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value.
     *
     * @param float|null $value
     *   Value to set.
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get the description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the description.
     *
     * @param string $description
     *   Description to set.
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMELement $element)
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

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_Price
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
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
