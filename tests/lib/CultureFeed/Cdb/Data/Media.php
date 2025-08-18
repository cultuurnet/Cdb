<?php

class CultureFeed_Cdb_Data_Media implements CultureFeed_Cdb_IElement, Iterator, Countable
{
    /**
     * Current position in the list.
     * @var int
     */
    protected $position = 0;

    /**
     * The list of details.
     * @var CultureFeed_Cdb_Data_File[]
     */
    protected $details = array();

    /**
     * Add a new file to the list.
     *
     * @param CultureFeed_Cdb_Data_File $file
     *   File to add.
     */
    public function add(CultureFeed_Cdb_Data_File $file)
    {
        $this->details[] = $file;
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
     * Remove the given position.
     */
    public function remove($position)
    {
        unset($this->details[$position]);
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMElement $element)
    {

        $dom = $element->ownerDocument;

        $mediaElement = $dom->createElement('media');

        foreach ($this as $file) {
            $file->appendToDom($mediaElement);
        }

        $element->appendChild($mediaElement);
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_Media
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {
        $media = new self();

        if (!empty($xmlElement->file)) {
            foreach ($xmlElement->file as $fileElement) {
                $media->add(
                    CultureFeed_Cdb_Data_File::parseFromCdbXml($fileElement)
                );
            }
        }

        return $media;
    }

    /**
     * @return self
     */
    public function byMediaType($type)
    {
        $media = new self();

        foreach ($this->details as $file) {
            if ($type == $file->getMediaType()) {
                $media->add($file);
            }
        }

        return $media;
    }

    /**
     * @return self
     */
    public function byMediaTypes($types)
    {
        $media = new self();

        foreach ($this->details as $file) {
            if (in_array($file->getMediaType(), $types)) {
                $media->add($file);
            }
        }

        return $media;
    }

    public function count()
    {
        return count($this->details);
    }
}
