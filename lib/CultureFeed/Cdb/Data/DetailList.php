<?php

/**
 * @class
 * Representation of a list of details in the cdb xml.
 */
abstract class CultureFeed_Cdb_Data_DetailList implements CultureFeed_Cdb_IElement, Iterator
{
    /**
     * Current position in the list.
     * @var int
     */
    protected $position = 0;

    /**
     * The list of details.
     * @var array
     */
    protected $details = array();

    /**
     * Add a new detail to the list.
     *
     * @param CultureFeed_Cdb_Data_Detail $detail
     *   Detail to add.
     */
    public function add(CultureFeed_Cdb_Data_Detail $detail)
    {
        $this->details[] = $detail;
    }

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
        return $this->details[$this->position];
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
        return isset($this->details[$this->position]);
    }

    /**
     * Get the details for a given language.
     *
     * @param string $language_code
     *   Language code to get.
     *
     * @return CultureFeed_Cdb_Data_Detail|NULL
     */
    public function getDetailByLanguage($language_code)
    {
        $this->rewind();
        foreach ($this as $detail) {
            if ($language_code == $detail->getLanguage()) {
                return $detail;
            }
        }
    }
}
