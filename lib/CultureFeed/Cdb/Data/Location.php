<?php

/**
 * @class
 * Representation of a location element in the cdb xml.
 */
class CultureFeed_Cdb_Data_Location implements CultureFeed_Cdb_IElement
{
    /**
     * Address from the location.
     * @var CultureFeed_Cdb_Data_Address
     */
    protected $address;

    /**
     * Location label.
     * @var string
     */
    protected $label;

    /**
     * Cdbid from location actor.
     */
    protected $cdbid;

    /**
     * @var string
     */
    protected $externalid;

    /**
     * Location actor.
     * @var CultureFeed_Cdb_Item_Actor
     */
    protected $actor;

    /**
     * Construct a new location.
     *
     * @param CultureFeed_Cdb_Data_Address $address
     *   Address from the location.
     */
    public function __construct(CultureFeed_Cdb_Data_Address $address)
    {
        $this->address = $address;
    }

    /**
     * Get the address.
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get the cdbid for this location.
     */
    public function getCdbid()
    {
        return $this->cdbid;
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalid;
    }

    /**
     * Get the label.
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return CultureFeed_Cdb_Item_Actor
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * @param CultureFeed_Cdb_Item_Actor $actor
     */
    public function setActor(CultureFeed_Cdb_Item_Actor $actor)
    {
        $this->actor = $actor;
    }

    /**
     * Set the address.
     *
     * @param CultureFeed_Cdb_Data_Address $address
     *   Address to set.
     */
    public function setAddress(CultureFeed_Cdb_Data_Address $address)
    {
        $this->address = $address;
    }

    /**
     * Set the cdbid for this location.
     *
     * @param string $cdbid
     */
    public function setCdbid($cdbid)
    {
        $this->cdbid = $cdbid;
    }

    /**
     * @param string $externalid
     */
    public function setExternalId($externalid)
    {
        $this->externalid = (string) $externalid;
    }

    /**
     * Set the label
     *
     * @param string $label
     *   Label to set.
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMELement $element)
    {

        $dom = $element->ownerDocument;

        $locationElement = $dom->createElement('location');

        if ($this->address) {
            $this->address->appendToDOM($locationElement);
        }

        if ($this->label) {
            $labelElement = $dom->createElement('label');
            $labelElement->appendChild($dom->createTextNode($this->label));

            if ($this->cdbid) {
                $labelElement->setAttribute('cdbid', $this->cdbid);
            }

            if ($this->externalid) {
                $labelElement->setAttribute('externalid', $this->externalid);
            }

            $locationElement->appendChild($labelElement);
        }

        if ($this->actor) {
            $this->actor->appendToDOM($locationElement);
        }

        $element->appendChild($locationElement);
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_Location
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {

        if (empty($xmlElement->address)) {
            throw new CultureFeed_Cdb_ParseException(
                "Address missing for location element"
            );
        }

        $address = CultureFeed_Cdb_Data_Address::parseFromCdbXml(
            $xmlElement->address
        );
        $location = new CultureFeed_Cdb_Data_Location($address);

        if (!empty($xmlElement->label)) {
            $attributes = $xmlElement->label->attributes();
            $location->setLabel((string) $xmlElement->label);

            if (isset($attributes['cdbid'])) {
                $location->setCdbid((string) $attributes['cdbid']);
            }

            if (isset($attributes['externalid'])) {
                $location->setExternalId((string) $attributes['externalid']);
            }
        }

        if (!empty($xmlElement->actor)) {
            $actor = CultureFeed_Cdb_Item_Actor::parseFromCdbXml(
                $xmlElement->actor
            );
            $location->setActor($actor);
        }

        return $location;
    }
}
