<?php

final class CultureFeed_Cdb_Data_Calendar_Period implements CultureFeed_Cdb_IElement
{
    private string $dateFrom;
    private string $dateTo;
    private ?CultureFeed_Cdb_Data_Calendar_Exceptions $exceptions = null;
    private ?CultureFeed_Cdb_Data_Calendar_Weekscheme $weekScheme = null;

    public function __construct(string $dateFrom, string $dateTo)
    {
        $this->setdateFrom($dateFrom);
        $this->setdateTo($dateTo);
    }

    public function getDateFrom(): string
    {
        return $this->dateFrom;
    }

    public function getDateTo(): string
    {
        return $this->dateTo;
    }

    public function getExceptions(): ?CultureFeed_Cdb_Data_Calendar_Exceptions
    {
        return $this->exceptions;
    }

    public function getWeekScheme(): ?CultureFeed_Cdb_Data_Calendar_Weekscheme
    {
        return $this->weekScheme;
    }

    public function setDateFrom(string $dateFrom): void
    {
        CultureFeed_Cdb_Data_Calendar::validateDate($dateFrom);
        $this->dateFrom = $dateFrom;
    }

    public function setDateTo(string $dateTo): void
    {
        CultureFeed_Cdb_Data_Calendar::validateDate($dateTo);
        $this->dateTo = $dateTo;
    }

    public function setExceptions(CultureFeed_Cdb_Data_Calendar_Exceptions $exceptions): void
    {
        $this->exceptions = $exceptions;
    }

    public function setWeekScheme(CultureFeed_Cdb_Data_Calendar_Weekscheme $scheme): void
    {
        $this->weekScheme = $scheme;
    }

    public function appendToDOM(DOMELement $element): void
    {
        $dom = $element->ownerDocument;

        $periodElement = $dom->createElement('period');
        $periodElement->appendChild(
            $dom->createElement('datefrom', $this->dateFrom)
        );
        $periodElement->appendChild(
            $dom->createElement('dateto', $this->dateTo)
        );

        if ($this->exceptions) {
            $this->exceptions->appendToDOM($periodElement);
        }

        if ($this->weekScheme) {
            $this->weekScheme->appendToDom($periodElement);
        }

        $element->appendChild($periodElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Calendar_Period
    {
        if (empty($xmlElement->datefrom)) {
            throw new CultureFeed_Cdb_ParseException(
                "Date from is missing for period"
            );
        }

        if (empty($xmlElement->dateto)) {
            throw new CultureFeed_Cdb_ParseException(
                "Date to is missing for period"
            );
        }

        $period = new CultureFeed_Cdb_Data_Calendar_Period(
            (string) $xmlElement->datefrom,
            (string) $xmlElement->dateto
        );

        if (!empty($xmlElement->weekscheme)) {
            $period->setWeekScheme(
                CultureFeed_Cdb_Data_Calendar_Weekscheme::parseFromCdbXml(
                    $xmlElement->weekscheme
                )
            );
        }

        if (!empty($xmlElement->exceptions)) {
            $period->setExceptions(
                CultureFeed_Cdb_Data_Calendar_Exceptions::parseFromCdbXml(
                    $xmlElement->exceptions
                )
            );
        }

        return $period;
    }
}
