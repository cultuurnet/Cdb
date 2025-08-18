<?php

class CultureFeed_Cdb_Data_LanguageList implements CultureFeed_Cdb_IElement, Iterator, Countable
{
    /**
     * Current position in the list.
     * @var int
     */
    protected $position = 0;

    /**
     * The list of languages.
     * @var array
     */
    protected $languages = array();

    /**
     * Add a new language to the list.
     *
     * @param CultureFeed_Cdb_Data_Language $language
     *   language to add.
     */
    public function add(CultureFeed_Cdb_Data_Language $language)
    {
        $this->languages[] = $language;
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
        return $this->languages[$this->position];
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
        return isset($this->languages[$this->position]);
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMElement $element)
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

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_LanguageList
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
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

    public function count()
    {
        return count($this->languages);
    }
}
