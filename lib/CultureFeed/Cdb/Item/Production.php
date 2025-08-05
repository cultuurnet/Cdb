<?php declare(strict_types=1);

final class CultureFeed_Cdb_Item_Production extends CultureFeed_Cdb_Item_Base implements CultureFeed_Cdb_IElement
{
    private int $ageFrom;
    private ?CultureFeed_Cdb_Data_Calendar_BookingPeriod $bookingPeriod = null;
    private int $maxParticipants;
    private CultureFeed_Cdb_Data_Organiser $organiser;

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Item_Production
    {
        if (empty($xmlElement->categories)) {
            throw new CultureFeed_Cdb_ParseException(
                'Categories are required for production element'
            );
        }

        if (empty($xmlElement->productiondetails)) {
            throw new CultureFeed_Cdb_ParseException(
                'Production details are required for production element'
            );
        }

        $attributes = $xmlElement->attributes();
        $production = new CultureFeed_Cdb_Item_Production();

        if (isset($attributes['cdbid'])) {
            $production->setCdbId((string) $attributes['cdbid']);
        }

        if (isset($attributes['externalid'])) {
            $production->setExternalId((string) $attributes['externalid']);
        }

        if (isset($attributes['availablefrom'])) {
            $production->setAvailableFrom(
                (string) $attributes['availablefrom']
            );
        }

        if (isset($attributes['availableto'])) {
            $production->setAvailableTo(
                (string) $attributes['availableto']
            );
        }

        if (isset($attributes['createdby'])) {
            $production->setCreatedBy((string) $attributes['createdby']);
        }

        if (isset($attributes['creationdate'])) {
            $production->setCreationDate(
                (string) $attributes['creationdate']
            );
        }

        if (!empty($xmlElement->agefrom)) {
            $production->setAgeFrom((int) $xmlElement->agefrom);
        }

        if (!empty($xmlElement->organiser)) {
            $production->setOrganiser(
                CultureFeed_Cdb_Data_Organiser::parseFromCdbXml(
                    $xmlElement->organiser
                )
            );
        }

        $production->setCategories(
            CultureFeed_Cdb_Data_CategoryList::parseFromCdbXml(
                $xmlElement->categories
            )
        );

        $production->setDetails(
            CultureFeed_Cdb_Data_ProductionDetailList::parseFromCdbXml(
                $xmlElement->productiondetails
            )
        );

        if (!empty($xmlElement->maxparticipants)) {
            $production->setMaxParticipants((int) $xmlElement->maxparticipants);
        }

        if (!empty($xmlElement->bookingperiod)) {
            $production->setBookingPeriod(
                CultureFeed_Cdb_Data_Calendar_BookingPeriod::parseFromCdbXml(
                    $xmlElement->bookingperiod
                )
            );
        }

        if (!empty($xmlElement->relatedevents) && isset($xmlElement->relatedevents->id)) {
            foreach ($xmlElement->relatedevents->id as $relatedItem) {
                $attributes = $relatedItem->attributes();

                $production->addRelation(
                    new CultureFeed_Cdb_Item_Reference(
                        (string) $attributes['cdbid']
                    )
                );
            }
        }

        self::parseKeywords($xmlElement, $production);

        return $production;
    }

    public function getAgeFrom(): int
    {
        return $this->ageFrom;
    }

    public function setAgeFrom(int $age): void
    {
        $this->ageFrom = $age;
    }

    public function getMaxParticipants(): int
    {
        return $this->maxParticipants;
    }

    public function setMaxParticipants(int $maxParticipants): void
    {
        $this->maxParticipants = $maxParticipants;
    }

    public function getBookingPeriod(): ?CultureFeed_Cdb_Data_Calendar_BookingPeriod
    {
        return $this->bookingPeriod;
    }

    public function setBookingPeriod(CultureFeed_Cdb_Data_Calendar_BookingPeriod $bookingPeriod): void
    {
        $this->bookingPeriod = $bookingPeriod;
    }

    public function getOrganiser(): CultureFeed_Cdb_Data_Organiser
    {
        return $this->organiser;
    }

    public function setOrganiser(CultureFeed_Cdb_Data_Organiser $organiser): void
    {
        $this->organiser = $organiser;
    }

    public function appendToDOM(DOMElement $element, string $cdbScheme = '3.2'): void
    {
        $dom = $element->ownerDocument;

        $productionElement = $dom->createElement('production');

        if ($this->availableFrom) {
            $productionElement->setAttribute(
                'availablefrom',
                $this->availableFrom
            );
        }

        if ($this->availableTo) {
            $productionElement->setAttribute('availableto', $this->availableTo);
        }

        if ($this->createdBy) {
            $productionElement->setAttribute('createdby', $this->createdBy);
        }

        if ($this->creationDate) {
            $productionElement->setAttribute(
                'creationdate',
                $this->creationDate
            );
        }

        if ($this->ageFrom) {
            $productionElement->appendChild(
                $dom->createElement('agefrom', (string) $this->ageFrom)
            );
        }

        if ($this->maxParticipants) {
            $productionElement->appendChild(
                $dom->createElement('maxparticipants', (string) $this->maxParticipants)
            );
        }

        if ($this->bookingPeriod) {
            $this->bookingPeriod->appendToDOM($productionElement);
        }

        if ($this->cdbId) {
            $productionElement->setAttribute('cdbid', $this->cdbId);
        }

        if ($this->externalId) {
            $productionElement->setAttribute('externalid', $this->externalId);
        }

        if ($this->categories) {
            $this->categories->appendToDOM($productionElement);
        }

        if ($this->details) {
            $this->details->appendToDOM($productionElement);
        }

        if (count($this->keywords) > 0) {
            $keywordElement = $dom->createElement('keywords');
            $keywordElement->appendChild(
                $dom->createTextNode(implode(';', array_map(fn ($keyword) => $keyword->getValue(), $this->keywords)))
            );
            $productionElement->appendChild($keywordElement);
        }

        if (!empty($this->relations)) {
            $relationsElement = $dom->createElement('eventrelations');

            foreach ($this->relations as $relation) {
                $relationElement = $dom->createElement('relatedproduction');
                $relationElement->appendChild(
                    $dom->createTextNode($relation->getTitle())
                );
                $relationElement->setAttribute('cdbid', $relation->getCdbid());
                $relationElement->setAttribute(
                    'externalid',
                    $relation->getExternalId()
                );
                $relationsElement->appendChild($relationElement);
            }

            $productionElement->appendChild($relationsElement);
        }

        $element->appendChild($productionElement);
    }
}
