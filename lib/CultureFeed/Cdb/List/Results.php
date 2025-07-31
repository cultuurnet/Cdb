<?php

/**
 * @class
 * Class for the representation of results found for a list search.
 */
class CultureFeed_Cdb_List_Results implements Iterator
{
    /**
     * Current position in the list.
     * @var int
     */
    protected $position = 0;

    /**
     * Total results found
     * @var string
     */
    protected $totalResultsFound;

    /**
     * Array with the found items for current search.
     * @var string
     */
    protected $items;

    /**
     * Add a new category to the list.
     *
     * @param CultureFeed_Cdb_Data_Category $category
     *   Category to add.
     */
    public function add(CultureFeed_Cdb_List_Item $item)
    {
        $this->items[] = $item;
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
     * Set the total number of results that are found.
     */
    public function setTotalResultsFound($totalResultsFound)
    {
        $this->totalResultsFound = $totalResultsFound;
    }

    /**
     * Get the total number of results found
     * @return number
     */
    public function getTotalResultsfound()
    {
        return $this->totalResultsFound;
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_List_Results
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {
        $results = new self();

        if ($xmlElement->list) {
            $results->items = self::parseFromCdbXmlList($xmlElement);
        } else {
            $results->items = self::parseFromCdbXmlXmlview($xmlElement);
        }

        $results->setTotalResultsFound((int) $xmlElement->nofrecords);

        return $results;
    }

    /**
     * Get the list items
     *
     * @param SimpleXMLElement $xmlElement
     *
     * @return array
     */
    protected static function parseFromCdbXmlList(SimpleXMLElement $xmlElement)
    {
        $items = array();

        foreach ($xmlElement->list->item as $item) {
            $items[] = CultureFeed_Cdb_List_Item::parseFromCdbXml($item);
        }

        return $items;
    }

    /**
     * Get the xmlview items
     *
     * @param SimpleXMLElement $xmlElement
     *
     * @return array
     */
    protected static function parseFromCdbXmlXmlview(SimpleXMLElement $xmlElement)
    {
        $items = array();

        if ($xmlElement->events) {
            $listName = 'events';
            $itemName = 'event';
        } elseif ($xmlElement->actors) {
            $listName = 'actors';
            $itemName = 'actor';
        } elseif ($xmlElement->productions) {
            $listName = 'productions';
            $itemName = 'production';
        }

        foreach ($xmlElement->listName->itemName as $item) {
            $items[] = CultureFeed_Cdb_Default::parseItem($item);
        }

        return $items;
    }
}
