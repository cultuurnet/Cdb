<?php

use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Data_KeywordTest extends TestCase
{
    public function testIsVisibleByDefault(): void
    {
        $keyword = new CultureFeed_Cdb_Data_Keyword('foo');

        $this->assertTrue($keyword->isVisible());
    }

    public function testVisibilityPassedToConstructor(): void
    {
        $visibleKeyword = new CultureFeed_Cdb_Data_Keyword('foo', true);
        $this->assertTrue($visibleKeyword->isVisible());

        $invisibleKeyword = new CultureFeed_Cdb_Data_Keyword('foo', false);
        $this->assertFalse($invisibleKeyword->isVisible());
    }

    public function testChangeVisibility(): void
    {
        $keyword = new CultureFeed_Cdb_Data_Keyword('foo');

        $keyword->setVisibility(false);

        $this->assertFalse($keyword->isVisible());

        $keyword->setVisibility(true);

        $this->assertTrue($keyword->isVisible());
    }

    /**
     * @return array<array<string>>
     */
    public function validKeywordValues(): array
    {
        return array(
            array('foo'),
            array('bar'),
        );
    }

    /**
     * @dataProvider validKeywordValues
     */
    public function testValidValue(string $validValue): void
    {
        $keyword = new CultureFeed_Cdb_Data_Keyword($validValue);
        $this->assertSame($validValue, $keyword->getValue());
    }

    public function testAppendToDOM(): void
    {
        /** @var CultureFeed_Cdb_Data_Keyword[] $keywords */
        $keywords = array(
            new CultureFeed_Cdb_Data_Keyword('foo'),
            new CultureFeed_Cdb_Data_Keyword('bar', false),
        );

        $dom = new DOMDocument('1.0', 'utf8');
        $root = $dom->createElement('keywords');
        $dom->appendChild($root);
        foreach ($keywords as $keyword) {
            $keyword->appendToDOM($root);
        }

        $this->assertXmlStringEqualsXmlFile(
            __DIR__ . '/samples/KeywordTest/keywords.xml',
            $dom->saveXML()
        );
    }
}
