<?php

/**
 * @class
 * Representation of a timestamp element in the cdb xml.
 */
class CultureFeed_Cdb_Data_Calendar_Timestamp implements CultureFeed_Cdb_IElement
{
    /**
     * Date from the timestamp.
     * @var string
     */
    protected $date;

    /**
     * Start time from the timestamp.
     * @var string
     */
    protected $startTime;

    /**
     * End time from the timestamp.
     * @var string
     */
    protected $endTime;

    /**
     * Open type for the timestamp.
     * @var string
     */
    protected $openType;

    /**
     * Construct a new calendar timestamp.
     *
     * @param string $date
     *   Date from the timestamp.
     * @param string $startTime
     *   Start time from the timestamp.
     * @param string $endTime
     *   End time from the timestamp.
     */
    public function __construct($date, $startTime = null, $endTime = null)
    {

        $this->setDate($date);

        if ($startTime !== null) {
            $this->setStartTime($startTime);
        }

        if ($endTime !== null) {
            $this->setEndTime($endTime);
        }
    }

    /**
     * Get the date.
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the chronological end date of a timestamp.
     * CDBXML only keeps track of one date and a set of start and end times.
     * When the end time is smaller than the start time we assume it's past midnight.
     * If this happens the end date is pushed to the next day to keep it chronological.
     * When start time and/or end time are missing the date is returned as is.
     *
     * @return string
     *  The end date as a string in the Y-m-d format. e.g.: 2017-05-25
     */
    public function getEndDate()
    {
        $dateFormat = 'Y-m-d';
        $dateTimeFormat = 'Y-m-d H:i:s';
        $startTime = $this->getStartTime();
        $endTime = $this->getEndTime();

        if (empty($startTime) || empty($endTime)) {
            return $this->getDate();
        }

        $startDateTime = DateTime::createFromFormat($dateTimeFormat, $this->getDate() . ' ' . $startTime);
        $endDateTime = DateTime::createFromFormat($dateTimeFormat, $this->getDate() . ' ' . $endTime);

        if ($endTime !== '00:00:00' && $endDateTime < $startDateTime) {
            $endDateTime->add(new DateInterval('P1D'));
        }

        return $endDateTime->format($dateFormat);
    }

    /**
     * Get the start time.
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Get the end time.
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Get the open type.
     */
    public function getOpenType()
    {
        return $this->openType;
    }

    /**
     * Set the date from the timestamp.
     *
     * @param string $date
     *   Date to set.
     */
    public function setDate($date)
    {
        CultureFeed_Cdb_Data_Calendar::validateDate($date);
        $this->date = $date;
    }

    /**
     * Set the start time from the timestamp.
     *
     * @param string $time
     *   Start time to set.
     */
    public function setStartTime($time)
    {
        CultureFeed_Cdb_Data_Calendar::validateTime($time);
        $this->startTime = $time;
    }

    /**
     * Set the end time from the timestamp.
     *
     * @param string $time
     *   End time to set.
     */
    public function setEndTime($time)
    {
        CultureFeed_Cdb_Data_Calendar::validateTime($time);
        $this->endTime = $time;
    }

    /**
     * Set the open type for the timestamp.
     *
     * @param string $type
     */
    public function setOpenType($type)
    {
        $this->openType = $type;
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMELement $element)
    {

        $dom = $element->ownerDocument;

        $timestampElement = $dom->createElement('timestamp');
        if ($this->openType) {
            $timestampElement->setAttribute('opentype', $this->openType);
        }

        $dateElement = $dom->createElement('date', $this->date);

        $timestampElement->appendChild($dateElement);

        if ($this->startTime) {
            $timeStartElement = $dom->createElement(
                'timestart',
                $this->startTime
            );
            $timestampElement->appendChild($timeStartElement);
        }

        if ($this->endTime) {
            $timeEndElement = $dom->createElement('timeend');
            $timeEndElement->appendChild($dom->createTextNode($this->endTime));
            $timestampElement->appendChild($timeEndElement);
        }

        $element->appendChild($timestampElement);
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_Calendar_Timestamp
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {

        if (empty($xmlElement->date)) {
            throw new CultureFeed_Cdb_ParseException(
                "Date is missing for timestamp"
            );
        }

        $attributes = $xmlElement->attributes();
        $timestamp = new CultureFeed_Cdb_Data_Calendar_Timestamp(
            (string) $xmlElement->date
        );

        if (isset($attributes['opentype'])) {
            $timestamp->setOpenType((string) $attributes['opentype']);
        }

        if (!empty($xmlElement->timestart)) {
            $timestamp->setStartTime((string) $xmlElement->timestart);
        }

        if (!empty($xmlElement->timeend)) {
            $timestamp->setEndTime((string) $xmlElement->timeend);
        }

        return $timestamp;
    }
}
