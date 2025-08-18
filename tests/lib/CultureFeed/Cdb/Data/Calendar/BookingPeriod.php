<?php

/**
 * @class
 * Representation of a booking period element in the cdb xml.
 */
class CultureFeed_Cdb_Data_Calendar_BookingPeriod implements CultureFeed_Cdb_IElement
{
    /**
     * Start date
     * @var int
     */
    protected $dateFrom;

    /**
     * End date
     * @var int
     */
    protected $dateTill;

    /**
     * Construct a new booking period.
     *
     * @param int $dateFrom
     *   Timestamp of the from date.
     * @param int $dateTill
     *   Timestamp of the end date.
     */
    public function __construct($dateFrom, $dateTill)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTill = $dateTill;
    }

    /**
     * Get the start date.
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Get the end date.
     */
    public function getDateTill()
    {
        return $this->dateTill;
    }

    /**
     * Set the from date.
     *
     * @param int
     *   Timestamp from the date.
     */
    public function setDateFrom($dateFrom)
    {

        if (!is_numeric($dateFrom)) {
            throw new UnexpectedValueException(
                'Invalid from date: ' . $dateFrom . ', value should be a timestamp'
            );
        }

        $this->dateFrom = $dateFrom;
    }

    /**
     * Set the till date.
     *
     * @param string $dateTill
     *   Till date to set.
     */
    public function setDateTill($dateTill)
    {

        if (!is_numeric($dateTill)) {
            throw new UnexpectedValueException(
                'Invalid from date: ' . $dateTill . ', value should be a timestamp'
            );
        }

        $this->dateTill = $dateTill;
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMELement $element)
    {

        $dom = $element->ownerDocument;

        $bookingElement = $dom->createElement('bookingperiod');

        $bookingElement->appendChild(
            $dom->createElement('datefrom', date('Y-m-d', $this->dateFrom))
        );
        $bookingElement->appendChild(
            $dom->createElement('dateto', date('Y-m-d', $this->dateTill))
        );

        $element->appendChild($bookingElement);
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_Calendar_BookingPeriod
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {

        if (empty($xmlElement->datefrom)) {
            throw new CultureFeed_Cdb_ParseException(
                "Required attribute 'datefrom' is missing on bookingperiod"
            );
        }

        if (empty($xmlElement->dateto)) {
            throw new CultureFeed_Cdb_ParseException(
                "Required attribute 'dateto' is missing on bookingperiod"
            );
        }

        $dateFrom = strtotime((string) $xmlElement->datefrom);
        $dateTill = strtotime((string) $xmlElement->dateto);

        return new CultureFeed_Cdb_Data_Calendar_BookingPeriod(
            $dateFrom,
            $dateTill
        );
    }
}
