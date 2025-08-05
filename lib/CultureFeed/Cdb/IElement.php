<?php

declare(strict_types=1);

interface CultureFeed_Cdb_IElement
{
    public function appendToDOM(DOMElement $element): void;
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_IElement;
}
