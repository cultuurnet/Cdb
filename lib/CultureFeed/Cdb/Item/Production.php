<?php

class CultureFeed_Cdb_Item_Production extends CultureFeed_Cdb_Item_Base implements CultureFeed_Cdb_IElement
{
    /**
     * Minimum age for the production.
     * @var int
     */
    protected $ageFrom;

    /**
     * Booking period for this event.
     * @var CultureFeed_Cdb_Data_Calendar_BookingPeriod
     */
    protected $bookingPeriod;

    /**
     * Maximum participants
     * @var int
     */
    protected $maxParticipants;

    /**
     * organiser
     * @var CultureFeed_Cdb_Data_Organiser
     */
    protected $organiser;

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     *
     * @return CultureFeed_Cdb_Item_Production
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {
        if (empty($xmlElement->productiondetails)) {
            throw new CultureFeed_ParseException(
                'Production details are required for production element'
            );
        }

        $attributes = $xmlElement->attributes();
        $production = new CultureFeed_Cdb_Item_Production();

        self::parseCommonAttributes($production, $xmlElement);
        self::parseCategories($production, $xmlElement);
        self::parseKeywords($production, $xmlElement);

        if (!empty($xmlElement->agefrom)) {
            $production->setAgeFrom((int) $xmlElement->agefrom);
        }

        // Set organiser.
        if (!empty($xmlElement->organiser)) {
            $production->setOrganiser(
                CultureFeed_Cdb_Data_Organiser::parseFromCdbXml(
                    $xmlElement->organiser
                )
            );
        }

        // Set production details.
        $production->setDetails(
            CultureFeed_Cdb_Data_ProductionDetailList::parseFromCdbXml(
                $xmlElement->productiondetails
            )
        );

        // Set max participants.
        if (!empty($xmlElement->maxparticipants)) {
            $production->setMaxParticipants((int) $xmlElement->maxparticipants);
        }

        // Set booking period.
        if (!empty($xmlElement->bookingperiod)) {
            $production->setBookingPeriod(
                CultureFeed_Cdb_Data_Calendar_BookingPeriod::parseFromCdbXml(
                    $xmlElement->bookingperiod
                )
            );
        }

        // Set the related events for this production.
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

        return $production;
    }

    /**
     * Get the minimum age for this production.
     */
    public function getAgeFrom()
    {
        return $this->ageFrom;
    }

    /**
     * Set the minimum age for this production.
     *
     * @param int $age
     *   Minimum age.
     *
     * @throws UnexpectedValueException
     */
    public function setAgeFrom($age)
    {

        if (!is_numeric($age)) {
            throw new UnexpectedValueException('Invalid age: ' . $age);
        }

        $this->ageFrom = $age;
    }

    /**
     * Get the maximum amount of participants.
     */
    public function getMaxParticipants()
    {
        return $this->maxParticipants;
    }

    /**
     * Set the maximum amount of participants.
     */
    public function setMaxParticipants($maxParticipants)
    {
        $this->maxParticipants = $maxParticipants;
    }

    /**
     * Get the booking period.
     */
    public function getBookingPeriod()
    {
        return $this->bookingPeriod;
    }

    /**
     * Set the booking period.
     */
    public function setBookingPeriod(CultureFeed_Cdb_Data_Calendar_BookingPeriod $bookingPeriod)
    {
        $this->bookingPeriod = $bookingPeriod;
    }

    /**
     * Get the organiser from this event.
     */
    public function getOrganiser()
    {
        return $this->organiser;
    }

    /**
     * Set an organiser.
     *
     * @param CultureFeed_Cdb_Data_Organiser $organiser
     */
    public function setOrganiser(CultureFeed_Cdb_Data_Organiser $organiser)
    {
        $this->organiser = $organiser;
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

        $productionElement = $dom->createElement('production');

        $this->appendCommonAttributesToDOM($productionElement, $cdbScheme);
        $this->appendCategoriesToDOM($productionElement, $cdbScheme);
        $this->appendKeywordsToDOM($productionElement, $cdbScheme);

        if ($this->ageFrom) {
            $productionElement->appendChild(
                $dom->createElement('agefrom', $this->ageFrom)
            );
        }

        if ($this->maxParticipants) {
            $productionElement->appendChild(
                $dom->createElement('maxparticipants', $this->maxParticipants)
            );
        }

        if ($this->bookingPeriod) {
            $this->bookingPeriod->appendToDOM($productionElement);
        }

        if ($this->details) {
            $this->details->appendToDOM($productionElement);
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
