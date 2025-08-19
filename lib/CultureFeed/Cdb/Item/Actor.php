<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Item_Actor extends CultureFeed_Cdb_Item_Base implements CultureFeed_Cdb_IElement
{
    private ?CultureFeed_Cdb_Data_ContactInfo $contactInfo = null;
    private ?CultureFeed_Cdb_Data_Calendar_Weekscheme $weekScheme = null;
    private bool $asset;

    public function __construct()
    {
        $this->details = new CultureFeed_Cdb_Data_ActorDetailList();
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Item_Actor
    {
        if (empty($xmlElement->actordetails)) {
            throw new CultureFeed_Cdb_ParseException(
                'Actordetails missing for actor element'
            );
        }

        $actor = new self();

        $attributes = $xmlElement->attributes();
        if (isset($attributes['asset'])) {
            $actor->setAsset((bool) $attributes['asset']);
        }

        self::parseCommonAttributes($actor, $xmlElement);
        self::parseKeywords($actor, $xmlElement);
        self::parseCategories($actor, $xmlElement);

        $actor->setDetails(
            CultureFeed_Cdb_Data_ActorDetailList::parseFromCdbXml(
                $xmlElement->actordetails
            )
        );

        if (!empty($xmlElement->contactinfo)) {
            $actor->setContactInfo(
                CultureFeed_Cdb_Data_ContactInfo::parseFromCdbXml(
                    $xmlElement->contactinfo
                )
            );
        }

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

    public function setAsset(bool $asset = true): void
    {
        $this->asset = $asset;
    }

    public function appendToDOM(DOMElement $element, string $cdbScheme = '3.2'): void
    {
        $dom = $element->ownerDocument;

        $actorElement = $dom->createElement('actor');

        $this->appendCommonAttributesToDOM($actorElement, $cdbScheme);

        if (isset($this->asset)) {
            $actorElement->setAttribute(
                'asset',
                $this->asset ? 'true' : 'false'
            );
        }

        if ($this->details) {
            $this->details->appendToDOM($actorElement);
        }

        $this->appendCategoriesToDOM($actorElement, $cdbScheme);

        if ($this->contactInfo) {
            $this->contactInfo->appendToDOM($actorElement);
        }

        $this->appendKeywordsToDOM($actorElement, $cdbScheme);

        if ($this->weekScheme) {
            $this->weekScheme->appendToDOM($actorElement);
        }

        $element->appendChild($actorElement);
    }
}
