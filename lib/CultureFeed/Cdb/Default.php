<?php

/**
 * @class
 * Representation of the cdb xml on the culturefeed.
 */
class CultureFeed_Cdb_Default
{
    /**
     * Url to the 3.2 cdb xml scheme.
     *
     * @deprecated Use CultureFeed_Cdb_Xml::namespaceUriForVersion() instead.
     */
    const CDB_SCHEME_URL = 'http://www.cultuurdatabank.com/XMLSchema/CdbXSD/3.2/FINAL';
    /**
     * Name from the xml scheme.
     */
    const CDB_SCHEME_NAME = 'cdbxml';

    /**
     * List of items to be placed in the CdbXml.
     * @var array
     */
    private $items = array();

    /**
     * The cdb schema url.
     *
     * @var string
     */
    private $cdb_schema_url;

    /**
     * The cdb schema version.
     *
     * @var string
     */
    private $cdb_schema_version = '3.2';

    /**
     * Creates a CultureFeed_Cdb_Default class.
     *
     * @param string $cdb_schema_version
     */
    public function __construct($cdb_schema_version = '3.2')
    {
        $this->cdb_schema_version = $cdb_schema_version;

        $this->cdb_schema_url = CultureFeed_Cdb_Xml::namespaceUriForVersion(
            $this->cdb_schema_version
        );
    }

    /**
     * Get the cdb schema url.
     *
     * @return string
     *   The schema url.
     */
    public function getSchemaUrl()
    {
        return $this->cdb_schema_url;
    }

    /**
     * Get the cdb schema url.
     *
     * @return string
     *   The schema url.
     */
    public function getSchemaVersion()
    {
        return $this->cdb_schema_version;
    }

    /**
     * Add an item from a  to the items list.
     *
     * @param CultureFeed_Cdb_Item_Base $item
     *  Item to add
     *
     * @throws Exception.
     */
    public function addItem(CultureFeed_Cdb_Item_Base $item)
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
     * Parse a given xml element to an CultureFeed_Cdb_Item_Base.
     *
     * @param SimpleXMLElement $xmlElement
     *   XML element from the item to parse.
     */
    public static function parseItem(SimpleXMLElement $xmlElement)
    {

        // Return the correct cdb item.
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

    /**
     * Print the Cdb.
     */
    public function __toString()
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
                    $item->appendToDOM($cdbElement, $this->getSchemaVersion());
                }
            }
        }

        return $dom->saveXML();
    }
}
