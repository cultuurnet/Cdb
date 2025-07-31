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
     * @var CultureFeed_Cdb_Data_Calendar_Weekscheme
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
        if (empty($xmlElement->categories)) {
            throw new CultureFeed_Cdb_ParseException(
                'Categories missing for actor element'
            );
        }

        if (empty($xmlElement->actordetails)) {
            throw new CultureFeed_Cdb_ParseException(
                'Actordetails missing for actor element'
            );
        }

        $actor = new self();

        CultureFeed_Cdb_Item_Base::parseCommonAttributes($actor, $xmlElement);

        $actor->setDetails(
            CultureFeed_Cdb_Data_ActorDetailList::parseFromCdbXml(
                $xmlElement->actordetails
            )
        );

        // Set categories
        $actor->setCategories(
            CultureFeed_Cdb_Data_CategoryList::parseFromCdbXml(
                $xmlElement->categories
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

        // Set the keywords.
        self::parseKeywords($xmlElement, $actor);

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
     * @param CultureFeed_Cdb_Data_ContactInfo $contactInfo
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

        if ($this->cdbId) {
            $actorElement->setAttribute('cdbid', $this->cdbId);
        }

        if ($this->externalId) {
            $actorElement->setAttribute('externalid', $this->externalId);
        }

        if ($this->details) {
            $this->details->appendToDOM($actorElement);
        }

        if ($this->categories) {
            $this->categories->appendToDOM($actorElement);
        }

        if ($this->contactInfo) {
            $this->contactInfo->appendToDOM($actorElement);
        }

        if ($this->createdBy) {
            $actorElement->setAttribute('createdby', $this->createdBy);
        }

        if ($this->creationDate) {
            $actorElement->setAttribute('creationdate', $this->creationDate);
        }

        if (isset($this->lastUpdated)) {
            $actorElement->setAttribute('lastupdated', $this->lastUpdated);
        }

        if (isset($this->lastUpdatedBy)) {
            $actorElement->setAttribute('lastupdatedby', $this->lastUpdatedBy);
        }

        if (count($this->keywords) > 0) {
            $keywordsElement = $dom->createElement('keywords');
            if (version_compare($cdbScheme, '3.3', '>=')) {
                foreach ($this->keywords as $keyword) {
                    $keyword->appendToDOM($keywordsElement);
                }
                $actorElement->appendChild($keywordsElement);
            } else {
                $keywords = array();
                foreach ($this->keywords as $keyword) {
                    $keywords[$keyword->getValue()] = $keyword->getValue();
                }
                $keywordsElement->appendChild(
                    $dom->createTextNode(implode(';', $keywords))
                );
                $actorElement->appendChild($keywordsElement);
            }
        }

        if ($this->weekScheme) {
            $this->weekScheme->appendToDOM($actorElement);
        }

        $element->appendChild($actorElement);
    }
}
