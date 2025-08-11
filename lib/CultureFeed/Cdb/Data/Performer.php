<?php

/**
 * @class
 * Representation of a category element in the cdb xml.
 */
class CultureFeed_Cdb_Data_Performer implements CultureFeed_Cdb_IElement
{
    /**
     * Label for the Performer.
     * @var string
     */
    protected $label;

    /**
     * Role of the performer.
     * @var string
     */
    protected $role;

    /**
     * Actor for the performer.
     * @var CultureFeed_Cdb_Item_Actor
     */
    protected $actor;

    public function __construct($role = null, $label = null)
    {
        $this->role = $role;
        $this->label = $label;
    }

    /**
     * Get the label of the performer.
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Get the role of the performer.
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get the actor.
     */
    public function getActor()
    {
        return $this->actor;
    }

    /**
     * Set the label of the performer.
     *
     * @param string $label
     *   Label of the performer
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Set the role of the performer.
     *
     * @param string $role
     *   Role of the performer
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Set the actor.
     *
     * @param CultureFeed_Cdb_Item_Actor $actor
     *   The actor.
     */
    public function setActor(CultureFeed_Cdb_Item_Actor $actor)
    {
        $this->actor = $actor;
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMElement $element)
    {

        $dom = $element->ownerDocument;

        $performerElement = $dom->createElement('performer');

        if ($this->role) {
            $roleElement = $dom->createElement('role');
            $roleElement->appendChild($dom->createTextNode($this->role));
            $performerElement->appendChild($roleElement);
        }

        $labelElement = $dom->createElement('label');
        $labelElement->appendChild($dom->createTextNode($this->label));
        $performerElement->appendChild($labelElement);

        $element->appendChild($performerElement);
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_Performer
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {

        $performer = new CultureFeed_Cdb_Data_Performer();

        if (!empty($xmlElement->label)) {
            $performer->setLabel((string) $xmlElement->label);
        }

        if (!empty($xmlElement->role)) {
            $performer->setRole((string) $xmlElement->role);
        }

        if (!empty($xmlElement->actor)) {
            $performer->setActor(
                CultureFeed_Cdb_Item_Actor::parseFromCdbXml($xmlElement->actor)
            );
        }

        return $performer;
    }
}
