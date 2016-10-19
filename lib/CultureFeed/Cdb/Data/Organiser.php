<?php

/**
 * @class
 * Representation of a organiser element in the cdb xml.
 */
class CultureFeed_Cdb_Data_Organiser implements CultureFeed_Cdb_IElement
{
    /**
     * Organiser label.
     * @var string
     */
    protected $label;

    /**
     * Cdbid from organiser actor.
     */
    protected $cdbid;

    /**
     * @var string
     */
    protected $externalid;

    /**
     * @var CultureFeed_Cdb_Item_Actor
     */
    protected $actor;

    /**
     * Get the cdbid for this organiser.
     */
    public function getCdbid()
    {
        return $this->cdbid;
    }

    /**
     * Get the label.
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the cdbid for this organiser.
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
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalid;
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
     * @param CultureFeed_Cdb_Item_Actor $actor
     */
    public function setActor(CultureFeed_Cdb_Item_Actor $actor)
    {
        $this->actor = $actor;
    }

    /**
     * @return CultureFeed_Cdb_Item_Actor
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMELement $element)
    {

        $dom = $element->ownerDocument;
        $organiserElement = $dom->createElement('organiser');

        if ($this->label) {
            $labelElement = $dom->createElement('label');
            $labelElement->appendChild($dom->createTextNode($this->label));

            if ($this->cdbid) {
                $labelElement->setAttribute('cdbid', $this->cdbid);
            }

            if ($this->externalid) {
                $labelElement->setAttribute('externalid', $this->externalid);
            }

            $organiserElement->appendChild($labelElement);
        }

        $element->appendChild($organiserElement);
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_Organiser
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {
        $organiser = new CultureFeed_Cdb_Data_Organiser();

        if (empty($xmlElement->label) && empty($xmlElement->actor)) {
            //throw new CultureFeed_Cdb_ParseException("One of the required fields (actor or label) is missing for organiser element");
        }

        if (!empty($xmlElement->label)) {
            $organiser->setLabel((string) $xmlElement->label);

            $attributes = $xmlElement->label->attributes();

            if (!empty($attributes->cdbid)) {
                $organiser->setCdbid((string) $attributes->cdbid);
            }

            if (!empty($attributes->externalid)) {
                $organiser->setExternalId($attributes->externalid);
            }
        } elseif (!empty($xmlElement->actor)) {
            $actor = CultureFeed_Cdb_Item_Actor::parseFromCdbXml(
                $xmlElement->actor
            );
            $organiser->setActor($actor);
        }

        return $organiser;
    }
}
