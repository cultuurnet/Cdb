<?php

final class CultureFeed_Cdb_List_Results implements Iterator
{
    private int $position = 0;
    private int $totalResultsFound;
    /**
     * @var CultureFeed_Cdb_List_Item[]
     */
    private array $items;

    public function add(CultureFeed_Cdb_List_Item $item): void
    {
        $this->items[] = $item;
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

    public function setTotalResultsFound(int $totalResultsFound): void
    {
        $this->totalResultsFound = $totalResultsFound;
    }

    public function getTotalResultsfound(): int
    {
        return $this->totalResultsFound;
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_List_Results
    {
        $results = new self();

        if ($xmlElement->list) {
            $results->items = self::parseFromCdbXmlList($xmlElement);
        } else {
            $results->items = self::parseFromCdbXmlXmlview($xmlElement);
        }

        $results->setTotalResultsFound(count($xmlElement->list->item));

        return $results;
    }

    public static function parseFromCdbXmlList(SimpleXMLElement $xmlElement): array
    {
        $items = array();

        foreach ($xmlElement->list->item as $item) {
            $items[] = CultureFeed_Cdb_List_Item::parseFromCdbXml($item);
        }

        return $items;
    }

    protected static function parseFromCdbXmlXmlview(SimpleXMLElement $xmlElement): array
    {
        $items = array();

        foreach ($xmlElement->listName->itemName as $item) {
            $items[] = CultureFeed_Cdb_Default::parseItem($item);
        }

        return $items;
    }
}
