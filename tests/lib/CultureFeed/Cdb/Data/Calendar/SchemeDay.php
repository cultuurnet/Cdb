<?php

/**
 * @class
 * Representation of a scheme day element in the cdb xml.
 */
class CultureFeed_Cdb_Data_Calendar_SchemeDay implements CultureFeed_Cdb_IElement
{
    const MONDAY = 'monday';
    const TUESDAY = 'tuesday';
    const WEDNESDAY = 'wednesday';
    const THURSDAY = 'thursday';
    const FRIDAY = 'friday';
    const SATURDAY = 'saturday';
    const SUNDAY = 'sunday';

    public static $allowedDays = array(
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
    );

    /**
     * Scheme open type: open
     * @var string
     */
    const SCHEMEDAY_OPEN_TYPE_OPEN = 'open';
    /**
     * Scheme open type: closed
     * @var string
     */
    const SCHEMEDAY_OPEN_TYPE_CLOSED = 'closed';
    /**
     * Scheme open type: byappointment
     * @var string
     */
    const SCHEMEDAY_OPEN_TYPE_BY_APPOINTMENT = 'byappointment';

    /**
     * Name of the week day
     * @var string
     */
    protected $dayName;

    /**
     * Open type for the day.
     * @var string
     */
    protected $openType;

    /**
     * Opening hours for that day.
     * @var array
     */
    protected $openingTimes = array();

    /**
     * Construct the scheme day.
     *
     * @param string $dayName
     *   Name of the day.
     * @param string $openType
     *   Open type for the day.
     */
    public function __construct($dayName, $openType = null)
    {

        $this->setDayName($dayName);
        if ($openType) {
            $this->openType = $openType;
        }
    }

    /**
     * Get the name from the day.
     */
    public function getDayName()
    {
        return $this->dayName;
    }

    /**
     * Get the opening type for this day.
     */
    public function getOpenType()
    {
        return $this->openType;
    }

    /**
     * Get the opening times.
     */
    public function getOpeningTimes()
    {
        return $this->openingTimes;
    }

    /**
     * Check if the current day is open or not.
     */
    public function isOpen()
    {
        return $this->openType == self::SCHEMEDAY_OPEN_TYPE_OPEN;
    }

    /**
     * Set the day name.
     *
     * @param string $dayName
     *   Name of the day to set.
     */
    public function setDayName($dayName)
    {

        if (!in_array($dayName, self::$allowedDays)) {
            throw new UnexpectedValueException('Invalid day: ' . $dayName);
        }

        $this->dayName = $dayName;
    }

    /**
     * Set the opening type.
     *
     * @param string $type
     *   Opening type to set.
     *
     * @return $this
     */
    public function setOpenType($type)
    {
        $this->openType = $type;

        return $this;
    }

    /**
     * @return $this
     */
    public function setClosed()
    {
        $this->setOpenType(self::SCHEMEDAY_OPEN_TYPE_CLOSED);

        return $this;
    }

    /**
     * @return $this
     */
    public function setOpen()
    {
        $this->setOpenType(self::SCHEMEDAY_OPEN_TYPE_OPEN);

        return $this;
    }

    /**
     * @return $this
     */
    public function setOpenByAppointment()
    {
        $this->setOpenType(self::SCHEMEDAY_OPEN_TYPE_BY_APPOINTMENT);

        return $this;
    }

    /**
     * Add an opening time.
     *
     * @param CultureFeed_Cdb_Data_Calendar_OpeningTime $openingTime
     *   Opening time to add.
     *
     * @return $this
     */
    public function addOpeningTime(CultureFeed_Cdb_Data_Calendar_OpeningTime $openingTime)
    {
        $this->openingTimes[] = $openingTime;

        return $this;
    }

    /**
     * Remove an opening time.
     *
     * @param int $i
     *   Index to remove.
     */
    public function removeOpeningTime($i)
    {

        if (!isset($this->openingTimes[$i])) {
            throw new Exception(
                'Trying to remove a non-existing opening time.'
            );
        }

        unset($this->openingTimes[$i]);
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMELement $element)
    {

        $dom = $element->ownerDocument;

        $dayElement = $dom->createElement($this->dayName);
        if ($this->openType) {
            $dayElement->setAttribute('opentype', $this->openType);
        }

        foreach ($this->openingTimes as $openingTime) {
            $openingTime->appendToDOM($dayElement);
        }

        $element->appendChild($dayElement);
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_Calendar_SchemeDay
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {

        $attributes = $xmlElement->attributes();
        if (!isset($attributes['opentype'])) {
            throw new CultureFeed_Cdb_ParseException(
                "Opentype is missing for day information"
            );
        }

        $day = new CultureFeed_Cdb_Data_Calendar_SchemeDay(
            $xmlElement->getName(),
            (string) $attributes['opentype']
        );

        if (isset($xmlElement->openingtime)) {
            foreach ($xmlElement->openingtime as $openingTimeElement) {
                $day->addOpeningTime(
                    CultureFeed_Cdb_Data_Calendar_OpeningTime::parseFromCdbXml(
                        $openingTimeElement
                    )
                );
            }
        }

        return $day;
    }
}
