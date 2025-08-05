<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Default
{
    /**
     * @deprecated Use CultureFeed_Cdb_Xml::namespaceUriForVersion() instead.
     */
    const CDB_SCHEME_URL = 'http://www.cultuurdatabank.com/XMLSchema/CdbXSD/3.2/FINAL';
    const CDB_SCHEME_NAME = 'cdbxml';

    /** @var array<string, array<CultureFeed_Cdb_IElement>> */
    private array $items = [];
    private string $cdb_schema_url;
    private string $cdb_schema_version = '3.2';

    public function __construct(string $cdb_schema_version = '3.2')
    {
        $this->cdb_schema_version = $cdb_schema_version;

        $this->cdb_schema_url = CultureFeed_Cdb_Xml::namespaceUriForVersion(
            $this->cdb_schema_version
        );
    }

    public function getSchemaUrl(): string
    {
        return $this->cdb_schema_url;
    }

    public function getSchemaVersion(): string
    {
        return $this->cdb_schema_version;
    }

    public function addItem(CultureFeed_Cdb_Item_Base $item): void
    {
        $type = get_class($item);

        switch ($type) {
            case 'CultureFeed_Cdb_Item_Actor':
                $this->items['actors'][] = $item;
                break;

            case 'CultureFeed_Cdb_Item_Event':
                $this->items['events'][] = $item;
                break;

            case 'CultureFeed_Cdb_Item_Production':
                $this->items['productions'][] = $item;
                break;

            default:
                throw new Exception(
                    "Trying to add an unknown item type '$type'"
                );
        }
    }

    /**
     * @return CultureFeed_Cdb_Item_Base|null
     */
    public static function parseItem(SimpleXMLElement $xmlElement)
    {
        switch ($xmlElement->getName()) {
            case 'event':
                return CultureFeed_Cdb_Item_Event::parseFromCdbXml($xmlElement);

            case 'production':
                return CultureFeed_Cdb_Item_Production::parseFromCdbXml(
                    $xmlElement
                );

            case 'actor':
                return CultureFeed_Cdb_Item_Actor::parseFromCdbXml($xmlElement);

            default:
                return null;
        }
    }

    public function __toString(): string
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $dom->preserveWhiteSpace = false;

        $cdbElement = $dom->createElementNS(
            $this->getSchemaUrl(),
            self::CDB_SCHEME_NAME
        );
        $cdbElement->setAttributeNS(
            'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation',
            $this->getSchemaUrl() . ' ' . $this->getSchemaUrl() . '/CdbXSD.xsd'
        );
        $dom->appendChild($cdbElement);

        foreach ($this->items as $type => $itemsFromType) {
            if ($itemsFromType) {
                foreach ($itemsFromType as $item) {
                    $item->appendToDOM($cdbElement);
                }
            }
        }

        return $dom->saveXML();
    }
}
