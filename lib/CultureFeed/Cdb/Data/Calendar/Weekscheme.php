<?php declare(strict_types=1);

/**
 * @method CultureFeed_Cdb_Data_Calendar_SchemeDay monday()
 * @method CultureFeed_Cdb_Data_Calendar_SchemeDay tuesday()
 * @method CultureFeed_Cdb_Data_Calendar_SchemeDay wednesday()
 * @method CultureFeed_Cdb_Data_Calendar_SchemeDay thursday()
 * @method CultureFeed_Cdb_Data_Calendar_SchemeDay friday()
 * @method CultureFeed_Cdb_Data_Calendar_SchemeDay saturday()
 * @method CultureFeed_Cdb_Data_Calendar_SchemeDay sunday()
 */
final class CultureFeed_Cdb_Data_Calendar_Weekscheme implements CultureFeed_Cdb_IElement
{
    /**
     * @var CultureFeed_Cdb_Data_Calendar_SchemeDay[]|null[]
     */
    private array $days = [
        'monday' => null,
        'tuesday' => null,
        'wednesday' => null,
        'thursday' => null,
        'friday' => null,
        'saturday' => null,
        'sunday' => null,
    ];

    public function setDay(string $dayName, CultureFeed_Cdb_Data_Calendar_SchemeDay $openingInfo): void
    {
        if (!array_key_exists($dayName, $this->days)) {
            throw new Exception('Trying to set unexisting day ' . $dayName);
        }

        $this->days[$dayName] = $openingInfo;
    }

    public function getDay(string $dayName): ?CultureFeed_Cdb_Data_Calendar_SchemeDay
    {
        if (!array_key_exists($dayName, $this->days)) {
            throw new Exception('Trying to access unexisting day ' . $dayName);
        }

        return $this->days[$dayName];
    }

    /**
     * @return array<CultureFeed_Cdb_Data_Calendar_SchemeDay>|array<null>
     */
    public function getDays(): array
    {
        return $this->days;
    }

    public function appendToDOM(DOMELement $element): void
    {
        $dom = $element->ownerDocument;

        $schemeElement = $dom->createElement('weekscheme');
        foreach ($this->days as $day) {
            if ($day) {
                $day->appendToDom($schemeElement);
            }
        }

        $element->appendChild($schemeElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Calendar_Weekscheme
    {
        foreach (CultureFeed_Cdb_Data_Calendar_SchemeDay::$allowedDays as $day) {
            if (!isset($xmlElement->{$day})) {
                throw new CultureFeed_Cdb_ParseException(
                    'Missing required data for ' . $day
                );
            }
        }

        $weekscheme = new CultureFeed_Cdb_Data_Calendar_Weekscheme();

        $weekscheme->setDay(
            'monday',
            CultureFeed_Cdb_Data_Calendar_SchemeDay::parseFromCdbXml(
                $xmlElement->monday
            )
        );
        $weekscheme->setDay(
            'tuesday',
            CultureFeed_Cdb_Data_Calendar_SchemeDay::parseFromCdbXml(
                $xmlElement->tuesday
            )
        );
        $weekscheme->setDay(
            'wednesday',
            CultureFeed_Cdb_Data_Calendar_SchemeDay::parseFromCdbXml(
                $xmlElement->wednesday
            )
        );
        $weekscheme->setDay(
            'thursday',
            CultureFeed_Cdb_Data_Calendar_SchemeDay::parseFromCdbXml(
                $xmlElement->thursday
            )
        );
        $weekscheme->setDay(
            'friday',
            CultureFeed_Cdb_Data_Calendar_SchemeDay::parseFromCdbXml(
                $xmlElement->friday
            )
        );
        $weekscheme->setDay(
            'saturday',
            CultureFeed_Cdb_Data_Calendar_SchemeDay::parseFromCdbXml(
                $xmlElement->saturday
            )
        );
        $weekscheme->setDay(
            'sunday',
            CultureFeed_Cdb_Data_Calendar_SchemeDay::parseFromCdbXml(
                $xmlElement->sunday
            )
        );

        return $weekscheme;
    }

    /**
     * @param array<mixed> $arguments
     */
    public function __call(string $name, array $arguments): CultureFeed_Cdb_Data_Calendar_SchemeDay
    {
        if (array_key_exists($name, $this->days)) {
            if (!$this->days[$name] instanceof CultureFeed_Cdb_Data_Calendar_SchemeDay) {
                $day = new CultureFeed_Cdb_Data_Calendar_SchemeDay($name);
                $this->setDay($name, $day);
            } else {
                $day = $this->days[$name];
            }

            return $day;
        }

        throw new Exception(
            "Call to undefined method {$name} of class " . __CLASS__
        );
    }
}
