<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Data_FileTest extends TestCase
{
    protected CultureFeed_Cdb_Data_File $file;

    public function setUp(): void
    {
        $this->file = new CultureFeed_Cdb_Data_File();
    }

    public function testAppendsFiletypeElementContainingFiletype(): void
    {
        $this->file->setFileType('jpeg');

        $dom = new DOMDocument();
        $mediaElement = $dom->createElement('media');
        $dom->appendChild($mediaElement);

        $this->file->appendToDOM($mediaElement);

        $xpath = new DOMXPath($dom);

        $items = $xpath->query('/media/file/filetype');
        $this->assertEquals(1, $items->length);

        $filetypeElement = $items->item(0);

        $this->assertEquals('jpeg', $filetypeElement->textContent);
    }

    public function testAppendsTitleElementContainingTitle(): void
    {
        // Ensure title contains a character like & which has
        // a special meaning in XML, to test for proper escaping.
        $title = 'cultuur & media';
        $this->file->setTitle($title);

        $dom = new DOMDocument();
        $mediaElement = $dom->createElement('media');
        $dom->appendChild($mediaElement);

        $this->file->appendToDOM($mediaElement);

        $xpath = new DOMXPath($dom);

        $items = $xpath->query('/media/file/title');
        $this->assertEquals(1, $items->length);

        $this->assertEquals($title, $items->item(0)->textContent);
    }

    public function testGetSubBrand(): void
    {
        $this->assertNull($this->file->getSubBrand());

        $subBrand = '2b88e17a-27fc-4310-9556-4df7188a051f';
        $this->file->setSubBrand($subBrand);

        $this->assertEquals($subBrand, $this->file->getSubBrand());
    }

    public function testAppendsSubBrand(): void
    {
        $subBrand = '2b88e17a-27fc-4310-9556-4df7188a051f';
        $this->file->setSubBrand($subBrand);

        $xpath = $this->xpathOnMediaWithFileAppended($this->file);
        $items = $xpath->query('/media/file/subbrand');
        $this->assertEquals(1, $items->length);

        $this->assertEquals($subBrand, $items->item(0)->textContent);
    }

    private function xpathOnMediaWithFileAppended(CultureFeed_Cdb_Data_File $file): DOMXPath
    {
        $dom = new DOMDocument();
        $mediaElement = $dom->createElement('media');
        $dom->appendChild($mediaElement);

        $file->appendToDOM($mediaElement);

        return new DOMXPath($dom);
    }

    public function testGetDescription(): void
    {
        $this->assertNull($this->file->getDescription());

        $description = 'Lorem Ipsum';
        $this->file->setDescription($description);

        $this->assertEquals($description, $this->file->getDescription());
    }
}
