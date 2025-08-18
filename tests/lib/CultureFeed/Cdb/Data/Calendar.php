<?php

abstract class CultureFeed_Cdb_Data_Calendar implements Iterator
{
    /**
     * Open type: the event is open.
     * @var string
     */
    const OPEN_TYPE_OPEN = 'open';
    /**
     * Open type: the event is closed.
     * @var string
     */
    const OPEN_TYPE_CLOSED = 'closed';
    /**
     * Open type: the event is appointment only.
     * @var string
     */
    const OPEN_TYPE_BYAPPOINTMENT = 'byappointment';
    /**
     * Regular expression for matching a ISO8601 formatted time (xml primitive
     * datatype xs:time).
     *
     * Source: "Regular Expressions Cookbook", ISBN-13 978-0-596-52068-7.
     */
    const ISO8601_REGEX_TIME = '^(2[0-3]|[0-1][0-9]):([0-5][0-9]):([0-5][0-9])(\.[0-9]+)??(Z|[+-](?:2[0-3]|[0-1][0-9]):[0-5][0-9])?$';

    /**
     * Current position in the list.
     * @var int
     */
    protected $position = 0;

    /**
     * The list of items.
     * @var array
     */
    protected $items = array();

    /**
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @see Iterator::current()
     */
    public function current()
    {
        return $this->items[$this->position];
    }

    /**
     * @see Iterator::key()
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @see Iterator::next()
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @see Iterator::valid()
     */
    public function valid()
    {
        return isset($this->items[$this->position]);
    }

    /**
     * Validate a given date.
     *
     * @param string $value
     *   Date to validate.
     *
     * @throws Exception
     */
    public static function validateDate($value)
    {
        if (!preg_match(
            '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',
            $value
        )
        ) {
            throw new UnexpectedValueException('Invalid date: ' . $value);
        }
    }

    /**
     * Validate a given time.
     *
     * @param string $value
     *   Time to validate.
     *
     * @throws Exception
     */
    public static function validateTime($value)
    {
        if (!preg_match('/' . self::ISO8601_REGEX_TIME . '/', $value)) {
            throw new UnexpectedValueException('Invalid time: ' . $value);
        }
    }
}
