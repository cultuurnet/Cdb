<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Item_Actor extends CultureFeed_Cdb_Item_Base implements CultureFeed_Cdb_IElement
{
    private ?CultureFeed_Cdb_Data_ContactInfo $contactInfo = null;
    private ?CultureFeed_Cdb_Data_Calendar_Weekscheme $weekScheme = null;

    public function __construct()
    {
        $this->details = new CultureFeed_Cdb_Data_ActorDetailList();
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Item_Actor
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

        $actor->setCategories(
            CultureFeed_Cdb_Data_CategoryList::parseFromCdbXml(
                $xmlElement->categories
            )
        );

        if (!empty($xmlElement->contactinfo)) {
            $actor->setContactInfo(
                CultureFeed_Cdb_Data_ContactInfo::parseFromCdbXml(
                    $xmlElement->contactinfo
                )
            );
        }

        self::parseKeywords($xmlElement, $actor);

        if (!empty($xmlElement->weekscheme)) {
            $actor->setWeekScheme(
                CultureFeed_Cdb_Data_Calendar_Weekscheme::parseFromCdbXml(
                    $xmlElement->weekscheme
                )
            );
        }

        return $actor;
    }


    public function getContactInfo(): ?CultureFeed_Cdb_Data_ContactInfo
    {
        return $this->contactInfo;
    }

    public function setContactInfo(CultureFeed_Cdb_Data_ContactInfo $contactInfo): void
    {
        $this->contactInfo = $contactInfo;
    }

    public function getWeekScheme(): ?CultureFeed_Cdb_Data_Calendar_Weekscheme
    {
        return $this->weekScheme;
    }

    public function setWeekScheme(CultureFeed_Cdb_Data_Calendar_Weekscheme $weekScheme): void
    {
        $this->weekScheme = $weekScheme;
    }

    public function appendToDOM(DOMElement $element, string $cdbScheme = '3.2'): void
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
                $keywords = [];
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
