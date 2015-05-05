<?php

class CultureFeed_Cdb_Data_FileTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CultureFeed_Cdb_Data_File
     */
    protected $file;

    public function setUp()
    {
        $this->file = new CultureFeed_Cdb_Data_File();
    }

    public function testAppendsFiletypeElementContainingFiletype()
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

    public function testAppendsTitleElementContainingTitle()
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

    public function testGetSubBrand()
    {
        $subBrand = '2b88e17a-27fc-4310-9556-4df7188a051f';
        $this->file->setSubBrand($subBrand);

        $this->assertEquals($subBrand, $this->file->getSubBrand());
    }

    public function testAppendsSubBrand()
    {
        $subBrand = '2b88e17a-27fc-4310-9556-4df7188a051f';
        $this->file->setSubBrand($subBrand);

        $xpath = $this->xpathOnMediaWithFileAppended($this->file);
        $items = $xpath->query('/media/file/subbrand');
        $this->assertEquals(1, $items->length);

        $this->assertEquals($subBrand, $items->item(0)->textContent);
    }

    /**
    * @return DOMXPath
    */
    private function xpathOnMediaWithFileAppended(CultureFeed_Cdb_Data_File $file)
    {
        $dom = new DOMDocument();
        $mediaElement = $dom->createElement('media');
        $dom->appendChild($mediaElement);

        $file->appendToDOM($mediaElement);

        return new DOMXPath($dom);
    }

}
