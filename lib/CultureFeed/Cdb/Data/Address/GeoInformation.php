<?php declare(strict_types=1);

final class CultureFeed_Cdb_Data_Address_GeoInformation implements CultureFeed_Cdb_IElement
{
    private string $xCoordinate;
    private string $yCoordinate;

    public function __construct(string $xCoordinate, string $yCoordinate)
    {
        $this->xCoordinate = $xCoordinate;
        $this->yCoordinate = $yCoordinate;
    }

    public function setXCoordinate(string $coordinate): void
    {
        $this->xCoordinate = $coordinate;
    }

    public function setYCoordinate(string $coordinate): void
    {
        $this->yCoordinate = $coordinate;
    }

    public function getXCoordinate(): string
    {
        return $this->xCoordinate;
    }

    public function getYCoordinate(): string
    {
        return $this->yCoordinate;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $gisElement = $dom->createElement('gis');
        $gisElement->appendChild(
            $dom->createElement('xcoordinate', $this->xCoordinate)
        );
        $gisElement->appendChild(
            $dom->createElement('ycoordinate', $this->yCoordinate)
        );

        $element->appendChild($gisElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Address_GeoInformation
    {
        if (empty($xmlElement->xcoordinate) || empty($xmlElement->ycoordinate)) {
            throw new CultureFeed_Cdb_ParseException(
                'Coördinates are missing on gis element'
            );
        }

        return new CultureFeed_Cdb_Data_Address_GeoInformation(
            (string) $xmlElement->xcoordinate,
            (string) $xmlElement->ycoordinate
        );
    }
}
