<?php

final class CultureFeed_Cdb_Data_Calendar_Timestamp implements CultureFeed_Cdb_IElement
{
    private string $date;
    private ?string $startTime = null;
    private ?string $endTime = null;
    private ?string $openType= null;

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
