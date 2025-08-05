<?php

final class CultureFeed_Cdb_Data_Calendar_SchemeDay implements CultureFeed_Cdb_IElement
{
    const MONDAY = 'monday';
    const TUESDAY = 'tuesday';
    const WEDNESDAY = 'wednesday';
    const THURSDAY = 'thursday';
    const FRIDAY = 'friday';
    const SATURDAY = 'saturday';
    const SUNDAY = 'sunday';

    /** @var array<string> */
    public static array $allowedDays = [
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
    ];

    const SCHEMEDAY_OPEN_TYPE_OPEN = 'open';
    const SCHEMEDAY_OPEN_TYPE_CLOSED = 'closed';
    const SCHEMEDAY_OPEN_TYPE_BY_APPOINTMENT = 'byappointment';

    private string $dayName;
    private string $openType;
    /** @var array<CultureFeed_Cdb_Data_Calendar_OpeningTime> */
    private array $openingTimes = [];

    public function __construct(string $dayName, string $openType = null)
    {
        $this->setDayName($dayName);
        if ($openType) {
            $this->openType = $openType;
        }
    }

    public function getDayName(): string
    {
        return $this->dayName;
    }

    public function getOpenType(): string
    {
        return $this->openType;
    }

    /**
     * @return array<CultureFeed_Cdb_Data_Calendar_OpeningTime>
     */
    public function getOpeningTimes(): array
    {
        return $this->openingTimes;
    }

    public function isOpen(): bool
    {
        return $this->openType == self::SCHEMEDAY_OPEN_TYPE_OPEN;
    }

    public function setDayName(string $dayName): void
    {

        if (!in_array($dayName, self::$allowedDays)) {
            throw new UnexpectedValueException('Invalid day: ' . $dayName);
        }

        $this->dayName = $dayName;
    }

    public function setOpenType(string $type): CultureFeed_Cdb_Data_Calendar_SchemeDay
    {
        $this->openType = $type;

        return $this;
    }

    public function setClosed(): CultureFeed_Cdb_Data_Calendar_SchemeDay
    {
        $this->setOpenType(self::SCHEMEDAY_OPEN_TYPE_CLOSED);

        return $this;
    }

    public function setOpen(): CultureFeed_Cdb_Data_Calendar_SchemeDay
    {
        $this->setOpenType(self::SCHEMEDAY_OPEN_TYPE_OPEN);

        return $this;
    }

    public function setOpenByAppointment(): CultureFeed_Cdb_Data_Calendar_SchemeDay
    {
        $this->setOpenType(self::SCHEMEDAY_OPEN_TYPE_BY_APPOINTMENT);

        return $this;
    }

    public function addOpeningTime(CultureFeed_Cdb_Data_Calendar_OpeningTime $openingTime): CultureFeed_Cdb_Data_Calendar_SchemeDay
    {
        $this->openingTimes[] = $openingTime;

        return $this;
    }

    public function removeOpeningTime(int $i): void
    {
        if (!isset($this->openingTimes[$i])) {
            throw new Exception(
                'Trying to remove a non-existing opening time.'
            );
        }

        unset($this->openingTimes[$i]);
    }

    public function appendToDOM(DOMELement $element): void
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

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Calendar_SchemeDay
    {
        $attributes = $xmlElement->attributes();
        if (!isset($attributes['opentype'])) {
            throw new CultureFeed_Cdb_ParseException(
                'Opentype is missing for day information'
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
