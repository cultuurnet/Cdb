<?php

final class CultureFeed_Cdb_Data_Calendar_BookingPeriod implements CultureFeed_Cdb_IElement
{
    private int $dateFrom;
    private int $dateTill;

    public function __construct(int $dateFrom, int $dateTill)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTill = $dateTill;
    }

    public function getDateFrom(): int
    {
        return $this->dateFrom;
    }

    public function getDateTill(): int
    {
        return $this->dateTill;
    }

    public function setDateFrom(int $dateFrom): void
    {
        $this->dateFrom = $dateFrom;
    }

    public function setDateTill(int $dateTill): void
    {
        $this->dateTill = $dateTill;
    }

    public function appendToDOM(DOMELement $element): void
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


    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Calendar_BookingPeriod
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
