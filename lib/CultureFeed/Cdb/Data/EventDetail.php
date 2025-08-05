<?php declare(strict_types=1);

final class CultureFeed_Cdb_Data_EventDetail extends CultureFeed_Cdb_Data_Detail implements CultureFeed_Cdb_IElement
{
    private string $calendarSummary;
    private ?CultureFeed_Cdb_Data_PerformerList $performers = null;

    public function __construct()
    {
        $this->media = new CultureFeed_Cdb_Data_Media();
    }

    public function getCalendarSummary(): string
    {
        return $this->calendarSummary;
    }

    public function getPerformers(): ?CultureFeed_Cdb_Data_PerformerList
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

        $detailElement = $dom->createElement('eventdetail');

        if (!empty($this->language)) {
            $detailElement->setAttribute('lang', $this->language);
        }

        if (!empty($this->calendarSummary)) {
            $summaryElement = $dom->createElement('calendarsummary');
            $summaryElement->appendChild(
                $dom->createTextNode($this->calendarSummary)
            );
            $detailElement->appendChild($summaryElement);
        }

        if ($this->performers && count($this->performers) > 0) {
            $this->performers->appendToDOM($detailElement);
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

        if ($this->title) {
            $titleElement = $dom->createElement('title');
            $titleElement->appendChild($dom->createTextNode($this->title));
            $detailElement->appendChild($titleElement);
        }

        $element->appendChild($detailElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_EventDetail
    {
        $attributes = $xmlElement->attributes();
        if (empty($attributes['lang'])) {
            throw new CultureFeed_Cdb_ParseException(
                'Lang missing for eventdetail element'
            );
        }

        $eventDetail = new CultureFeed_Cdb_Data_EventDetail();

        $eventDetail->setLanguage((string) $attributes['lang']);

        if (!empty($xmlElement->title)) {
            $eventDetail->setTitle((string) $xmlElement->title);
        }

        if (!empty($xmlElement->shortdescription)) {
            $eventDetail->setShortDescription(
                (string) $xmlElement->shortdescription
            );
        }

        if (!empty($xmlElement->longdescription)) {
            $eventDetail->setLongDescription(
                (string) $xmlElement->longdescription
            );
        }

        if (!empty($xmlElement->calendarsummary)) {
            $eventDetail->setCalendarSummary(
                (string) $xmlElement->calendarsummary
            );
        }

        // Set Performers.
        if (!empty($xmlElement->performers)) {
            $eventDetail->setPerformers(
                CultureFeed_Cdb_Data_PerformerList::parseFromCdbXml(
                    $xmlElement->performers
                )
            );
        }

        if (!empty($xmlElement->media->file)) {
            foreach ($xmlElement->media->file as $fileElement) {
                $eventDetail->media->add(
                    CultureFeed_Cdb_Data_File::parseFromCdbXML($fileElement)
                );
            }
        }

        if (!empty($xmlElement->price)) {
            $eventDetail->setPrice(
                CultureFeed_Cdb_Data_Price::parseFromCdbXml($xmlElement->price)
            );
        }

        return $eventDetail;
    }
}
