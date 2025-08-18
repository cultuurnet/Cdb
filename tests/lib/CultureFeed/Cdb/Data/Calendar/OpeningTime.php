<?php

/**
 * @class
 * Representation of an openingTime element in the cdb xml.
 */
class CultureFeed_Cdb_Data_Calendar_OpeningTime implements CultureFeed_Cdb_IElement
{
    /**
     * Start time from the opening hour.
     * @var string
     */
    protected $openFrom;

    /**
     * End time from the opening hour.
     * @var string
     */
    protected $openTill;

    /**
     * Construct a new openingTime.
     *
     * @param string $openFrom
     *   Start time for the opening time.
     * @param string|null $openTill
     *   End time for the opening time.
     */
    public function __construct($openFrom, $openTill = null)
    {
        $this->setOpenFrom($openFrom);

        if ($openTill) {
            $this->setOpenTill($openTill);
        }
    }

    /**
     * Get the opening from time.
     */
    public function getOpenFrom()
    {
        return $this->openFrom;
    }

    /**
     * Get the opening from time.
     */
    public function getOpenTill()
    {
        return $this->openTill;
    }

    /**
     * Set the opening from time.
     *
     * @param string $openFrom
     *   Opening time to set.
     */
    public function setOpenFrom($openFrom)
    {
        CultureFeed_Cdb_Data_Calendar::validateTime($openFrom);
        $this->openFrom = $openFrom;
    }

    /**
     * Set the open till time.
     *
     * @param string $openTill
     *   Open till time to set.
     */
    public function setOpenTill($openTill)
    {
        CultureFeed_Cdb_Data_Calendar::validateTime($openTill);
        $this->openTill = $openTill;
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMELement $element)
    {

        $dom = $element->ownerDocument;

        $openingElement = $dom->createElement('openingtime');
        $openingElement->setAttribute('from', $this->openFrom);
        if ($this->openTill) {
            $openingElement->setAttribute('to', $this->openTill);
        }

        $element->appendChild($openingElement);
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_Calendar_OpeningTime
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {

        $attributes = $xmlElement->attributes();
        if (!isset($attributes['from']) || empty($attributes['from'])) {
            $openFrom = '00:00:00';
        } else {
            $openFrom = (string) $attributes['from'];
        }

        $openTill = null;
        if (isset($attributes['to'])) {
            $openTill = (string) $attributes['to'];
        }

        return new CultureFeed_Cdb_Data_Calendar_OpeningTime(
            $openFrom,
            $openTill
        );
    }
}
