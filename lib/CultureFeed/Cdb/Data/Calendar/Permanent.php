<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_Calendar_Permanent extends CultureFeed_Cdb_Data_Calendar implements CultureFeed_Cdb_IElement
{
    private ?CultureFeed_Cdb_Data_Calendar_Exceptions $exceptions = null;
    private ?CultureFeed_Cdb_Data_Calendar_Weekscheme $weekScheme = null;

    public function setExceptions(CultureFeed_Cdb_Data_Calendar_Exceptions $exceptions): void
    {
        $this->exceptions = $exceptions;
    }

    public function setWeekScheme(CultureFeed_Cdb_Data_Calendar_Weekscheme $scheme): void
    {
        $this->weekScheme = $scheme;
    }

    public function getWeekScheme(): ?CultureFeed_Cdb_Data_Calendar_Weekscheme
    {
        return $this->weekScheme;
    }

    public function getExceptions(): ?CultureFeed_Cdb_Data_Calendar_Exceptions
    {
        return $this->exceptions;
    }

    public function appendToDOM(DOMELement $element): void
    {
        $dom = $element->ownerDocument;

        $calendarElement = $dom->createElement('calendar');
        $openingTimesElement = $dom->createElement('permanentopeningtimes');
        $permanentElement = $dom->createElement('permanent');

        if ($this->exceptions) {
            $this->exceptions->appendToDOM($permanentElement);
        }

        if ($this->weekScheme) {
            $this->weekScheme->appendToDom($permanentElement);
        }

        $openingTimesElement->appendChild($permanentElement);
        $calendarElement->appendChild($openingTimesElement);
        $element->appendChild($calendarElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Calendar_Permanent
    {
        if (!isset($xmlElement->permanentopeningtimes->permanent)) {
            throw new CultureFeed_Cdb_ParseException(
                'Permanent data is missing for permanent opening times'
            );
        }

        $permanentXml = $xmlElement->permanentopeningtimes->permanent;
        $calendar = new CultureFeed_Cdb_Data_Calendar_Permanent();

        if (!empty($permanentXml->weekscheme)) {
            $calendar->setWeekScheme(
                CultureFeed_Cdb_Data_Calendar_Weekscheme::parseFromCdbXml(
                    $permanentXml->weekscheme
                )
            );
        }

        if (!empty($permanentXml->exceptions)) {
            $calendar->setExceptions(
                CultureFeed_Cdb_Data_Calendar_Exceptions::parseFromCdbXml(
                    $permanentXml->exceptions
                )
            );
        }

        return $calendar;
    }
}
