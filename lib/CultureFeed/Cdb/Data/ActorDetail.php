<?php

final class CultureFeed_Cdb_Data_ActorDetail extends CultureFeed_Cdb_Data_Detail implements CultureFeed_Cdb_IElement
{
    private string $calendarSummary;

    public function __construct()
    {
        $this->media = new CultureFeed_Cdb_Data_Media();
    }

    public function getCalendarSummary(): string
    {
        return $this->calendarSummary;
    }

    public function setCalendarSummary(string $summary): void
    {
        $this->calendarSummary = $summary;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $detailElement = $dom->createElement('actordetail');
        $detailElement->setAttribute('lang', $this->language);

        if ($this->calendarSummary) {
            $summaryElement = $dom->createElement('calendarsummary');
            $summaryElement->appendChild(
                $dom->createTextNode($this->calendarSummary)
            );
            $detailElement->appendChild(
                $dom->createTextNode($this->calendarSummary)
            );
        }

        if (!empty($this->longDescription)) {
            $descriptionElement = $dom->createElement('longdescription');
            $descriptionElement->appendChild(
                $dom->createTextNode($this->longDescription)
            );
            $detailElement->appendChild($descriptionElement);
        }

        if (count($this->media) > 0) {
            $this->media->appendToDOM($detailElement);
        }

        if (!empty($this->shortDescription)) {
            $descriptionElement = $dom->createElement('shortdescription');
            $descriptionElement->appendChild(
                $dom->createTextNode($this->shortDescription)
            );
            $detailElement->appendChild($descriptionElement);
        }

        $titleElement = $dom->createElement('title');
        $titleElement->appendChild($dom->createTextNode($this->title));
        $detailElement->appendChild($titleElement);

        $element->appendChild($detailElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_ActorDetail
    {
        if (empty($xmlElement->title)) {
            throw new CultureFeed_Cdb_ParseException(
                'Title missing for actordetail element'
            );
        }

        $attributes = $xmlElement->attributes();
        if (empty($attributes['lang'])) {
            throw new CultureFeed_Cdb_ParseException(
                'Lang missing for actordetail element'
            );
        }

        $actorDetail = new self();
        $actorDetail->setTitle((string) $xmlElement->title);
        $actorDetail->setLanguage((string) $attributes['lang']);

        if (!empty($xmlElement->calendarsummary)) {
            $actorDetail->setCalendarSummary(
                (string) $xmlElement->calendarsummary
            );
        }

        if (!empty($xmlElement->shortdescription)) {
            $actorDetail->setShortDescription(
                (string) $xmlElement->shortdescription
            );
        }

        if (!empty($xmlElement->longdescription)) {
            $actorDetail->setLongDescription(
                (string) $xmlElement->longdescription
            );
        }

        if (!empty($xmlElement->media->file)) {
            foreach ($xmlElement->media->file as $fileElement) {
                $actorDetail->media->add(
                    CultureFeed_Cdb_Data_File::parseFromCdbXML($fileElement)
                );
            }
        }

        return $actorDetail;
    }
}
