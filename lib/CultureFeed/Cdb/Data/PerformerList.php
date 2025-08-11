<?php

/**
 * @implements Iterator<CultureFeed_Cdb_Data_Performer>
 */
final class CultureFeed_Cdb_Data_PerformerList implements CultureFeed_Cdb_IElement, Iterator, Countable
{
    private int $position = 0;
    /** @var array<CultureFeed_Cdb_Data_Performer> */
    private array $performers = [];

    public function add(CultureFeed_Cdb_Data_Performer $performer): void
    {
        $this->performers[] = $performer;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->performers[$this->position];
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
        return isset($this->performers[$this->position]);
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $performersElement = $dom->createElement('performers');
        foreach ($this as $performer) {
            $performer->appendToDom($performersElement);
        }

        $element->appendChild($performersElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_PerformerList
    {
        $performerList = new CultureFeed_Cdb_Data_PerformerList();

        if (!empty($xmlElement->performer)) {
            foreach ($xmlElement->performer as $performerElement) {
                $performerList->add(
                    CultureFeed_Cdb_Data_Performer::parseFromCdbXml(
                        $performerElement
                    )
                );
            }
        }

        return $performerList;
    }

    public function count(): int
    {
        return count($this->performers);
    }
}
