<?php

/**
 * @class
 * Representation of an actor on the culturefeed.
 */
class CultureFeed_Cdb_Item_Actor extends CultureFeed_Cdb_Item_Base implements CultureFeed_Cdb_IElement
{
    /**
     * Is the actor object centrally guarded for uniqueness
     * @var bool
     */
    protected $asset;

    /**
     * Contact info for an actor.
     *
     * @var CultureFeed_Cdb_Data_ContactInfo
     */
    protected $contactInfo;

    /**
     * @var CultureFeed_Cdb_Data_ActorDetailList
     */
    protected $details;

    /**
     * Week scheme for the opening times from the actor.
     * @var CultureFeed_Cdb_Data_Calendar_WeekScheme
     */
    protected $weekScheme;

    /**
     * Construct the actor.
     */
    public function __construct()
    {
        $this->details = new CultureFeed_Cdb_Data_ActorDetailList();
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @throws CultureFeed_Cdb_ParseException
     * @return CultureFeed_Cdb_Item_Actor
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {
        if (empty($xmlElement->actordetails)) {
            throw new CultureFeed_Cdb_ParseException(
                'Actordetails missing for actor element'
            );
        }

        $actor = new self();

        self::parseCommonAttributes($actor, $xmlElement);
        self::parseKeywords($actor, $xmlElement);
        self::parseCategories($actor, $xmlElement);

        $actor->setDetails(
            CultureFeed_Cdb_Data_ActorDetailList::parseFromCdbXml(
                $xmlElement->actordetails
            )
        );

        // Set contact information.
        if (!empty($xmlElement->contactinfo)) {
            $actor->setContactInfo(
                CultureFeed_Cdb_Data_ContactInfo::parseFromCdbXml(
                    $xmlElement->contactinfo
                )
            );
        }

        // Set the weekscheme.
        if (!empty($xmlElement->weekscheme)) {
            $actor->setWeekScheme(
                CultureFeed_Cdb_Data_Calendar_Weekscheme::parseFromCdbXml(
                    $xmlElement->weekscheme
                )
            );
        }

        return $actor;
    }

    /**
     * Get the contact info of this actor.
     */
    public function getContactInfo()
    {
        return $this->contactInfo;
    }

    /**
     * Set the contact info of this contact.
     *
     * @param CultureFeed_Cdb_Data_Calendar $contactInfo
     *   Contact info to set.
     */
    public function setContactInfo(CultureFeed_Cdb_Data_ContactInfo $contactInfo)
    {
        $this->contactInfo = $contactInfo;
    }

    /**
     * Get the weekscheme of this actor.
     */
    public function getWeekScheme()
    {
        return $this->weekScheme;
    }

    /**
     * Get the weekscheme of this actor.
     */
    public function setWeekScheme(CultureFeed_Cdb_Data_Calendar_Weekscheme $weekScheme)
    {
        $this->weekScheme = $weekScheme;
    }

    /**
     * Appends the current object to the passed DOM tree.
     *
     * @param DOMElement $element
     *   The DOM tree to append to.
     * @param string $cdbScheme
     *   The cdb schema version.
     *
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMElement $element, $cdbScheme = '3.2')
    {
        $dom = $element->ownerDocument;

        $actorElement = $dom->createElement('actor');

        $this->appendCommonAttributesToDOM($actorElement, $cdbScheme);
        $this->appendKeywordsToDOM($actorElement, $cdbScheme);
        $this->appendCategoriesToDOM($actorElement, $cdbScheme);

        if ($this->asset == true) {
            $actorElement->setAttribute('asset', true);
        }

        if ($this->details) {
            $this->details->appendToDOM($actorElement);
        }

        if ($this->contactInfo) {
            $this->contactInfo->appendToDOM($actorElement);
        }

        if ($this->weekScheme) {
            $this->weekScheme->appendToDOM($actorElement);
        }

        $element->appendChild($actorElement);
    }
}
