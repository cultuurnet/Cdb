<?php

final class CultureFeed_Cdb_Data_LanguageList implements CultureFeed_Cdb_IElement, Iterator, Countable
{
    private int $position = 0;
    /**
     * @var CultureFeed_Cdb_Data_Language[]
     */
    private array $languages = [];

    public function add(CultureFeed_Cdb_Data_Language $language): void
    {
        $this->languages[] = $language;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->languages[$this->position];
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
        return isset($this->languages[$this->position]);
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        if (count($this) > 0) {
            $languagesElement = $dom->createElement('languages');
            foreach ($this as $language) {
                $language->appendToDom($languagesElement);
            }

            $element->appendChild($languagesElement);
        }
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_LanguageList
    {
        $languageList = new self();

        if (!empty($xmlElement->language)) {
            foreach ($xmlElement->language as $languageElement) {
                $languageList->add(
                    CultureFeed_Cdb_Data_Language::parseFromCdbXml(
                        $languageElement
                    )
                );
            }
        }

        return $languageList;
    }

    public function count(): int
    {
        return count($this->languages);
    }
}
