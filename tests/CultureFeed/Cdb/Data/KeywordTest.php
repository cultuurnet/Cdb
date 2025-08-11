<?php

use PHPUnit\Framework\TestCase;

/**
 * @file
 */
class CultureFeed_Cdb_Data_KeywordTest extends TestCase
{
    public function testIsVisibleByDefault()
    {
        $keyword = new CultureFeed_Cdb_Data_Keyword('foo');

        $this->assertTrue($keyword->isVisible());
    }

    public function testVisibilityPassedToConstructor()
    {
        $visibleKeyword = new CultureFeed_Cdb_Data_Keyword('foo', true);
        $this->assertTrue($visibleKeyword->isVisible());

        $invisibleKeyword = new CultureFeed_Cdb_Data_Keyword('foo', false);
        $this->assertFalse($invisibleKeyword->isVisible());
    }

    public function testChangeVisibility()
    {
        $keyword = new CultureFeed_Cdb_Data_Keyword('foo');

        $keyword->setVisibility(false);

        $this->assertFalse($keyword->isVisible());

        $keyword->setVisibility(true);

        $this->assertTrue($keyword->isVisible());
    }

    /**
     * Provider for valid keyword values.
     *
     * @return array
     */
    public function validKeywordValues()
    {
        return array(
            array('foo'),
            array('bar'),
        );
    }

    /**
     * @dataProvider validKeywordValues
     *
     * @param string $validValue
     */
    public function testValidValue($validValue)
    {
        $keyword = new CultureFeed_Cdb_Data_Keyword($validValue);
        $this->assertSame($validValue, $keyword->getValue());
    }

    /**
     * Test append to dom.
     */
    public function testAppendToDOM()
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
