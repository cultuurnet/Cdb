<?php

declare(strict_types=1);

/**
 * @implements Iterator<CultureFeed_Cdb_IElement>
 */
abstract class CultureFeed_Cdb_Data_Calendar implements CultureFeed_Cdb_IElement, Iterator
{
    public const OPEN_TYPE_OPEN = 'open';
    public const OPEN_TYPE_CLOSED = 'closed';
    public const OPEN_TYPE_BYAPPOINTMENT = 'byappointment';
    /**
     * Regular expression for matching a ISO8601 formatted time (xml primitive
     * datatype xs:time).
     *
     * Source: "Regular Expressions Cookbook", ISBN-13 978-0-596-52068-7.
     */
    public const ISO8601_REGEX_TIME = '^(2[0-3]|[0-1][0-9]):([0-5][0-9]):([0-5][0-9])(\.[0-9]+)??(Z|[+-](?:2[0-3]|[0-1][0-9]):[0-5][0-9])?$';

    protected int $position = 0;
    /** @var array<CultureFeed_Cdb_IElement> */
    protected array $items = [];

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): CultureFeed_Cdb_IElement
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

    public static function validateDate(string $value): void
    {
        if (!preg_match(
            '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
            $value
        )
        ) {
            throw new UnexpectedValueException('Invalid date: ' . $value);
        }
    }

    public static function validateTime(string $value): void
    {
        if (!preg_match('/' . self::ISO8601_REGEX_TIME . '/', $value)) {
            throw new UnexpectedValueException('Invalid time: ' . $value);
        }
    }
}
