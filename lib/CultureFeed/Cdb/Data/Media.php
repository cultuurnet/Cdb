<?php

declare(strict_types=1);

/**
 * @implements Iterator<CultureFeed_Cdb_Data_File>
 */
final class CultureFeed_Cdb_Data_Media implements CultureFeed_Cdb_IElement, Iterator, Countable
{
    private int $position = 0;
    /** @var array<CultureFeed_Cdb_Data_File> */
    private array $details = [];

    public function add(CultureFeed_Cdb_Data_File $file): void
    {
        $this->details[] = $file;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): CultureFeed_Cdb_Data_File
    {
        return $this->details[$this->position];
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
        return isset($this->details[$this->position]);
    }

    public function remove(int $position): void
    {
        unset($this->details[$position]);
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $mediaElement = $dom->createElement('media');

        foreach ($this as $file) {
            $file->appendToDom($mediaElement);
        }

        $element->appendChild($mediaElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Media
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

    public function byMediaType(string $type): CultureFeed_Cdb_Data_Media
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
     * @param string[] $types
     */
    public function byMediaTypes(array $types): CultureFeed_Cdb_Data_Media
    {
        $media = new self();

        foreach ($this->details as $file) {
            if (in_array($file->getMediaType(), $types)) {
                $media->add($file);
            }
        }

        return $media;
    }

    public function count(): int
    {
        return count($this->details);
    }
}
