<?php

final class CultureFeed_Cdb_Data_ProductionDetail extends CultureFeed_Cdb_Data_Detail implements CultureFeed_Cdb_IElement
{
    private string $calendarSummary;
    private CultureFeed_Cdb_Data_PerformerList $performers;

    public function __construct()
    {
        $this->media = new CultureFeed_Cdb_Data_Media();
    }

    public function getCalendarSummary(): string
    {
        return $this->calendarSummary;
    }

    public function getPerformers(): CultureFeed_Cdb_Data_PerformerList
    {
        return $this->performers;
    }

    public function setCalendarSummary(string $summary): void
    {
        $this->calendarSummary = $summary;
    }

    public function setPerformers(CultureFeed_Cdb_Data_PerformerList $performers): void
    {
        $this->performers = $performers;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $detailElement = $dom->createElement('productiondetail');
        $detailElement->setAttribute('lang', $this->language);

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

        if (count($this->performers) > 0) {
            $this->performers->appendToDOM($detailElement);
        }

        if (!empty($this->price)) {
            $this->price->appendToDOM($detailElement);
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

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_ProductionDetail
    {
        if (empty($xmlElement->title)) {
            throw new CultureFeed_Cdb_ParseException(
                'Title missing for productiondetail element'
            );
        }

        $attributes = $xmlElement->attributes();
        if (empty($attributes['lang'])) {
            throw new CultureFeed_Cdb_ParseException(
                'Language (lang) missing for productiondetail element'
            );
        }

        $productionDetail = new CultureFeed_Cdb_Data_ProductionDetail();
        $productionDetail->setTitle((string) $xmlElement->title);
        $productionDetail->setLanguage((string) $attributes['lang']);

        if (!empty($xmlElement->shortdescription)) {
            $productionDetail->setShortDescription(
                (string) $xmlElement->shortdescription
            );
        }

        if (!empty($xmlElement->longdescription)) {
            $productionDetail->setLongDescription(
                (string) $xmlElement->longdescription
            );
        }

        if (!empty($xmlElement->calendarsummary)) {
            $productionDetail->setCalendarSummary(
                (string) $xmlElement->calendarsummary
            );
        }

        // Set Performers.
        if (!empty($xmlElement->performers)) {
            $productionDetail->setPerformers(
                CultureFeed_Cdb_Data_PerformerList::parseFromCdbXml(
                    $xmlElement->performers
                )
            );
        }

        // Add the media files.
        if (!empty($xmlElement->media->file)) {
            foreach ($xmlElement->media->file as $fileElement) {
                $productionDetail->media->add(
                    CultureFeed_Cdb_Data_File::parseFromCdbXML($fileElement)
                );
            }
        }

        return $productionDetail;
    }
}
