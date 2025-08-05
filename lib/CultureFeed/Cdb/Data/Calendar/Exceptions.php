<?php

declare(strict_types=1);

/**
 * @implements Iterator<CultureFeed_Cdb_Data_Calendar_Timestamp>
 */
final class CultureFeed_Cdb_Data_Calendar_Exceptions implements CultureFeed_Cdb_IElement, Iterator
{
    private int $position = 0;
    /** @var array<CultureFeed_Cdb_Data_Calendar_Timestamp> */
    private array $items = [];

    public function add(CultureFeed_Cdb_Data_Calendar_Timestamp $timestamp): void
    {
        $this->items[] = $timestamp;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->items[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->items[$this->position]);
    }

    public function appendToDOM(DOMELement $element): void
    {
        $dom = $element->ownerDocument;

        $exceptionsElement = $dom->createElement('exceptions');
        foreach ($this as $timestamp) {
            $timestamp->appendToDom($exceptionsElement);
        }

        $element->appendChild($exceptionsElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Calendar_Exceptions
    {
        $exceptions = new CultureFeed_Cdb_Data_Calendar_Exceptions();

        foreach ($xmlElement->timestamp as $timestampElement) {
            $exceptions->add(
                CultureFeed_Cdb_Data_Calendar_Timestamp::parseFromCdbXml(
                    $timestampElement
                )
            );
        }

        return $exceptions;
    }
}
