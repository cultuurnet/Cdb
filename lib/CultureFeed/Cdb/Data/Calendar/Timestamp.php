<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_Calendar_Timestamp implements CultureFeed_Cdb_IElement
{
    private string $date;
    private ?string $startTime = null;
    private ?string $endTime = null;
    private ?string $openType = null;

    public function __construct(string $date, string $startTime = null, string $endTime = null)
    {
        $this->setDate($date);

        if ($startTime !== null) {
            $this->setStartTime($startTime);
        }

        if ($endTime !== null) {
            $this->setEndTime($endTime);
        }
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function getEndTime(): ?string
    {
        return $this->endTime;
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
    public function getEndDate(): string
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

    public function getOpenType(): ?string
    {
        return $this->openType;
    }

    public function setDate(string $date): void
    {
        CultureFeed_Cdb_Data_Calendar::validateDate($date);
        $this->date = $date;
    }

    public function setStartTime(string $time): void
    {
        CultureFeed_Cdb_Data_Calendar::validateTime($time);
        $this->startTime = $time;
    }

    public function setEndTime(string $time): void
    {
        CultureFeed_Cdb_Data_Calendar::validateTime($time);
        $this->endTime = $time;
    }

    public function setOpenType(string $type): void
    {
        $this->openType = $type;
    }

    public function appendToDOM(DOMELement $element): void
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

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Calendar_Timestamp
    {
        if (empty($xmlElement->date)) {
            throw new CultureFeed_Cdb_ParseException(
                'Date is missing for timestamp'
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
