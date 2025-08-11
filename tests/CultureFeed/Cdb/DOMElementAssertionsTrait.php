<?php

trait CultureFeed_Cdb_DOMElementAssertionsTrait
{
    public function assertEqualDOMElement(DOMElement $expected, DOMElement $actual)
    {
        $this->assertEquals($expected->nodeName, $actual->nodeName);
        $this->assertEquals($expected->attributes->length, $actual->attributes->length);

        foreach ($expected->attributes as $attr) {
            $this->assertTrue($actual->hasAttribute($attr->name));
            $this->assertEquals($attr->value, $actual->getAttribute($attr->name));
        }
    }
}