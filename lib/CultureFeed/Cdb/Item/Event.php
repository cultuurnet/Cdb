<?php declare(strict_types=1);

final class CultureFeed_Cdb_Item_Event extends CultureFeed_Cdb_Item_Base implements CultureFeed_Cdb_IElement
{
    private ?int $ageFrom = null;
    private ?CultureFeed_Cdb_Data_Calendar_BookingPeriod $bookingPeriod = null;
    private ?CultureFeed_Cdb_Data_Calendar $calendar = null;
    private ?CultureFeed_Cdb_Data_ContactInfo $contactInfo = null;
    private ?bool $isParent = null;
    private ?CultureFeed_Cdb_Data_LanguageList $languages = null;
    private ?CultureFeed_Cdb_Data_Location $location = null;
    private ?int $maxParticipants = null;
    private ?CultureFeed_Cdb_Data_Organiser $organiser = null;
    private ?float $pctComplete = null;
    private ?bool $published = null;
    private ?string $validator = null;
    private ?int $weight = null;

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Item_Event
    {
        if (empty($xmlElement->calendar)) {
            throw new CultureFeed_Cdb_ParseException(
                'Calendar missing for event element'
            );
        }

        if (empty($xmlElement->categories)) {
            throw new CultureFeed_Cdb_ParseException(
                'Categories missing for event element'
            );
        }

        if (empty($xmlElement->contactinfo)) {
            throw new CultureFeed_Cdb_ParseException(
                'Contact info missing for event element'
            );
        }

        if (empty($xmlElement->eventdetails)) {
            throw new CultureFeed_Cdb_ParseException(
                'Eventdetails missing for event element'
            );
        }

        if (empty($xmlElement->location)) {
            throw new CultureFeed_Cdb_ParseException(
                'Location missing for event element'
            );
        }

        $event_attributes = $xmlElement->attributes();
        $event = new CultureFeed_Cdb_Item_Event();

        CultureFeed_Cdb_Item_Base::parseCommonAttributes($event, $xmlElement);

        if (isset($event_attributes['private'])) {
            $event->setPrivate(
                filter_var(
                    (string) $event_attributes['private'],
                    FILTER_VALIDATE_BOOLEAN
                )
            );
        }

        if (isset($event_attributes['isparent'])) {
            $event->setIsParent(
                filter_var(
                    (string) $event_attributes['isparent'],
                    FILTER_VALIDATE_BOOLEAN
                )
            );
        }

        if (isset($event_attributes['pctcomplete'])) {
            $event->setPctComplete(floatval($event_attributes['pctcomplete']));
        }

        if (isset($event_attributes['published'])) {
            $event->setPublished(
                filter_var(
                    (string) $event_attributes['published'],
                    FILTER_VALIDATE_BOOLEAN
                )
            );
        }

        if (isset($event_attributes['validator'])) {
            $event->setValidator((string) $event_attributes['validator']);
        }

        if (isset($event_attributes['weight'])) {
            $event->setWeight((int) $event_attributes['weight']);
        }

        if (isset($xmlElement->agefrom)) {
            $event->setAgeFrom((int) $xmlElement->agefrom);
        }

        // Set calendar information.
        $calendar_type = key($xmlElement->calendar);
        if ($calendar_type == 'permanentopeningtimes') {
            $event->setCalendar(
                CultureFeed_Cdb_Data_Calendar_Permanent::parseFromCdbXml(
                    $xmlElement->calendar
                )
            );
        } elseif ($calendar_type == 'timestamps') {
            $event->setCalendar(
                CultureFeed_Cdb_Data_Calendar_TimestampList::parseFromCdbXml(
                    $xmlElement->calendar->timestamps
                )
            );
        } elseif ($calendar_type == 'periods') {
            $event->setCalendar(
                CultureFeed_Cdb_Data_Calendar_PeriodList::parseFromCdbXml(
                    $xmlElement->calendar
                )
            );
        }

        // Set categories
        $event->setCategories(
            CultureFeed_Cdb_Data_CategoryList::parseFromCdbXml(
                $xmlElement->categories
            )
        );

        // Set contact information.
        $event->setContactInfo(
            CultureFeed_Cdb_Data_ContactInfo::parseFromCdbXml(
                $xmlElement->contactinfo
            )
        );

        // Set event details.
        $event->setDetails(
            CultureFeed_Cdb_Data_EventDetailList::parseFromCdbXml(
                $xmlElement->eventdetails
            )
        );

        // Set location.
        $event->setLocation(
            CultureFeed_Cdb_Data_Location::parseFromCdbXml(
                $xmlElement->location
            )
        );

        // Set organiser
        if (!empty($xmlElement->organiser)) {
            $event->setOrganiser(
                CultureFeed_Cdb_Data_Organiser::parseFromCdbXml(
                    $xmlElement->organiser
                )
            );
        }

        // Set max participants.
        if (!empty($xmlElement->maxparticipants)) {
            $event->setMaxParticipants((int) $xmlElement->maxparticipants);
        }

        // Set booking period.
        if (!empty($xmlElement->bookingperiod)) {
            $event->setBookingPeriod(
                CultureFeed_Cdb_Data_Calendar_BookingPeriod::parseFromCdbXml(
                    $xmlElement->bookingperiod
                )
            );
        }

        // Set relations.
        if (!empty($xmlElement->eventrelations) && !empty($xmlElement->eventrelations->relatedproduction)) {
            foreach ($xmlElement->eventrelations->relatedproduction as $relatedProduction) {
                $attributes = $relatedProduction->attributes();

                $event->addRelation(
                    new CultureFeed_Cdb_Item_Reference(
                        (string) $attributes['cdbid'],
                        (string) $relatedProduction,
                        (string) $attributes['externalid']
                    )
                );
            }
        }
        self::parseKeywords($xmlElement, $event);

        if (!empty($xmlElement->languages)) {
            $event->setLanguages(
                CultureFeed_Cdb_Data_LanguageList::parseFromCdbXml(
                    $xmlElement->languages
                )
            );
        }

        return $event;
    }

    public function setIsParent(bool $value): void
    {
        $this->isParent = $value;
    }

    public function isParent(): ?bool
    {
        return $this->isParent;
    }

    public function getPctComplete(): ?float
    {
        return $this->pctComplete;
    }

    public function setPctComplete(float $pct): void
    {
        $this->pctComplete = $pct;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $value = true): void
    {
        $this->published = $value;
    }

    public function getValidator(): ?string
    {
        return $this->validator;
    }

    public function setValidator(string $value): void
    {
        $this->validator = $value;
    }

    public function getAgeFrom(): ?int
    {
        return $this->ageFrom;
    }

    public function setAgeFrom(int $age): void
    {
        $this->ageFrom = $age;
    }

    public function getCalendar(): ?CultureFeed_Cdb_Data_Calendar
    {
        return $this->calendar;
    }

    public function setCalendar(CultureFeed_Cdb_Data_Calendar $calendar): void
    {
        $this->calendar = $calendar;
    }

    public function getLocation(): ?CultureFeed_Cdb_Data_Location
    {
        return $this->location;
    }

    public function setLocation(CultureFeed_Cdb_Data_Location $location): void
    {
        $this->location = $location;
    }

    public function getOrganiser(): ?CultureFeed_Cdb_Data_Organiser
    {
        return $this->organiser;
    }

    public function setOrganiser(CultureFeed_Cdb_Data_Organiser $organiser): void
    {
        $this->organiser = $organiser;
    }

    public function getContactInfo(): ?CultureFeed_Cdb_Data_ContactInfo
    {
        return $this->contactInfo;
    }

    public function setContactInfo(CultureFeed_Cdb_Data_ContactInfo $contactInfo): void
    {
        $this->contactInfo = $contactInfo;
    }

    public function getMaxParticipants(): ?int
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

    public function getLanguages(): ?CultureFeed_Cdb_Data_LanguageList
    {
        return $this->languages;
    }

    public function setLanguages(CultureFeed_Cdb_Data_LanguageList $languages): void
    {
        $this->languages = $languages;
    }

    public function deleteOrganiser(): void
    {
        $this->organiser = null;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    public function appendToDOM(DOMElement $element, string $cdbScheme = '3.2'): void
    {
        $dom = $element->ownerDocument;

        $eventElement = $dom->createElement('event');

        if ($this->ageFrom) {
            $eventElement->appendChild(
                $dom->createElement('agefrom', (string) $this->ageFrom)
            );
        }

        if ($this->availableFrom) {
            $eventElement->setAttribute('availablefrom', $this->availableFrom);
        }

        if ($this->availableTo) {
            $eventElement->setAttribute('availableto', $this->availableTo);
        }

        if ($this->cdbId) {
            $eventElement->setAttribute('cdbid', $this->cdbId);
        }

        if ($this->createdBy) {
            $eventElement->setAttribute('createdby', $this->createdBy);
        }

        if ($this->creationDate) {
            $eventElement->setAttribute('creationdate', $this->creationDate);
        }

        if ($this->externalId) {
            $eventElement->setAttribute('externalid', $this->externalId);
        }

        if (isset($this->isParent)) {
            $eventElement->setAttribute(
                'isparent',
                $this->isParent ? 'true' : 'false'
            );
        }

        if (isset($this->lastUpdated)) {
            $eventElement->setAttribute('lastupdated', $this->lastUpdated);
        }

        if (isset($this->lastUpdatedBy)) {
            $eventElement->setAttribute('lastupdatedby', $this->lastUpdatedBy);
        }

        if (isset($this->owner)) {
            $eventElement->setAttribute('owner', $this->owner);
        }

        if (isset($this->pctComplete)) {
            $eventElement->setAttribute('pctcomplete', (string) $this->pctComplete);
        }

        if (isset($this->private)) {
            $eventElement->setAttribute(
                'private',
                $this->private ? 'true' : 'false'
            );
        }

        if (isset($this->published)) {
            $eventElement->setAttribute(
                'published',
                $this->published ? 'true' : 'false'
            );
        }

        if (isset($this->validator)) {
            $eventElement->setAttribute('validator', $this->validator);
        }

        if (isset($this->wfStatus)) {
            $eventElement->setAttribute('wfstatus', $this->wfStatus);
        }

        if ($this->publisher) {
            $eventElement->setAttribute('publisher', $this->publisher);
        }

        if ($this->calendar) {
            $this->calendar->appendToDOM($eventElement);
        }

        if ($this->categories) {
            $this->categories->appendToDOM($eventElement);
        }

        if ($this->contactInfo) {
            $this->contactInfo->appendToDOM($eventElement);
        }

        if ($this->details) {
            $this->details->appendToDOM($eventElement);
        }

        if (count($this->keywords) > 0) {
            $keywordsElement = $dom->createElement('keywords');
            if (version_compare($cdbScheme, '3.3', '>=')) {
                foreach ($this->keywords as $keyword) {
                    $keyword->appendToDOM($keywordsElement);
                }
                $eventElement->appendChild($keywordsElement);
            } else {
                $keywords = [];
                foreach ($this->keywords as $keyword) {
                    $keywords[$keyword->getValue()] = $keyword->getValue();
                }
                $keywordsElement->appendChild(
                    $dom->createTextNode(implode(';', $keywords))
                );
                $eventElement->appendChild($keywordsElement);
            }
        }

        if (isset($this->languages)) {
            $this->languages->appendToDOM($eventElement);
        }

        if ($this->location) {
            $this->location->appendToDOM($eventElement);
        }

        if ($this->organiser) {
            $this->organiser->appendToDOM($eventElement);
        }

        if ($this->maxParticipants) {
            $eventElement->appendChild(
                $dom->createElement('maxparticipants', (string) $this->maxParticipants)
            );
        }

        if ($this->bookingPeriod) {
            $this->bookingPeriod->appendToDOM($eventElement);
        }

        if (!empty($this->relations)) {
            $relationsElement = $dom->createElement('eventrelations');

            foreach ($this->relations as $relation) {
                $relationElement = $dom->createElement('relatedproduction');
                $relationElement->appendChild(
                    $dom->createTextNode($relation->getTitle())
                );
                $relationElement->setAttribute('cdbid', $relation->getCdbid());

                $externalId = $relation->getExternalId();
                if ($externalId) {
                    $relationElement->setAttribute(
                        'externalid',
                        $relation->getExternalId()
                    );
                }

                $relationsElement->appendChild($relationElement);
            }

            $eventElement->appendChild($relationsElement);
        }

        $element->appendChild($eventElement);
    }
}
