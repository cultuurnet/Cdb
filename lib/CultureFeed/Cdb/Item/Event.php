<?php

/**
 * @class
 * Representation of an event on the culturefeed.
 */
class CultureFeed_Cdb_Item_Event extends CultureFeed_Cdb_Item_Base implements CultureFeed_Cdb_IElement {

  /**
   * @var string
   */
  protected $availableFrom;

  /**
   * @var string
   */
  protected $availableTo;

  /**
   * @var string
   */
  protected $createdBy;

  /**
   * @var string
   */
  protected $creationDate;

  /**
   * @var bool
   */
  protected $isParent;

  /**
   * @var string
   */
  protected $lastUpdated;

  /**
   * @var string
   */
  protected $lastUpdatedBy;

  /**
   * @var string
   */
  protected $owner;

  /**
   * @var float
   */
  protected $pctComplete;

  /**
   * @var bool
   */
  protected $published;

  /**
   * @var string
   */
  protected $validator;

  /**
   * @var string
   */
  protected $wfStatus;

  /**
   * Publication date for the event.
   *
   * @var string
   */
  protected $publicationDate;

  /**
   * Publication hour for the event.
   *
   * @var string
   */
  protected $publicationTime = '00:00:00';

  /**
   * Minimum age for the event.
   * @var int
   */
  protected $ageFrom;

  /**
   * Calendar information for the event.
   * @var CultureFeed_Cdb_Data_Calendar
   */
  protected $calendar;

  /**
   * Contact info for an event.
   *
   * @var CultureFeed_Cdb_Data_ContactInfo
   */
  protected $contactInfo;

  /**
   * Location of an event.
   *
   * @var CultureFeed_Cdb_Data_Location
   */
  protected $location;

  /**
   * Organiser of an event.
   *
   * @var CultureFeed_Cdb_Data_Organiser
   */
  protected $organiser;

  /**
   * Maximum participants
   * @var int
   */
  protected $maxParticipants;

  /**
   * Booking period for this event.
   * @var CultureFeed_Cdb_Data_Calendar_BookingPeriod
   */
  protected $bookingPeriod;

  public function setAvailableFrom($value) {
    $this->availableFrom = $value;
  }

  public function getAvailableFrom() {
    return $this->availableFrom;
  }

  public function setAvailableTo($value) {
    $this->availableTo = $value;
  }

  public function getAvailableTo() {
    return $this->availableTo;
  }

  public function setCreatedBy($author) {
    $this->createdBy = $author;
  }

  public function getCreatedBy() {
    return $this->createdBy;
  }

  public function setCreationDate($value) {
    $this->creationDate = $value;
  }

  public function getCreationDate() {
    return $this->creationDate;
  }

  /**
   * @return bool
   */
  public function isParent() {
    return $this->isParent;
  }

  /**
   * @param bool $value
   */
  public function setIsParent($value) {
    $this->isParent = $value;
  }

  public function getLastUpdated() {
    return $this->lastUpdated;
  }

  public function setLastUpdated($value) {
    $this->lastUpdated = $value;
  }

  public function getLastUpdatedBy() {
    return $this->lastUpdatedBy;
  }

  public function setLastUpdatedBy($author) {
    $this->lastUpdatedBy = $author;
  }

  public function getOwner() {
    return $this->owner;
  }

  public function setOwner($owner) {
    $this->owner = $owner;
  }

  public function getPctComplete() {
    return $this->pctComplete;
  }

  public function setPctComplete($pct) {
    $this->pctComplete = $pct;
  }

  /**
   * @return bool
   */
  public function isPublished() {
    return $this->published;
  }

  /**
   * @param bool $value
   */
  public function setPublished($value) {
    $this->published = $value;
  }

  /**
   * @return string
   */
  public function getValidator() {
    return $this->validator;
  }

  /**
   * @param string $value
   */
  public function setValidator($value) {
    $this->validator = $value;
  }

  /**
   * @return string
   */
  public function getWfStatus() {
    return $this->wfStatus;
  }

  /**
   * @param string $status
   */
  public function setWfStatus($status) {
    $this->wfStatus = $status;
  }

  /**
   * Get the publication date for this event.
   */
  public function getPublicationDate() {
    return $this->publicationDate;
  }

  /**
   * Get the publication time for this event.
   */
  public function getPublicationTime() {
    return $this->publicationTime;
  }

  /**
   * Get the minimum age for this event.
   */
  public function getAgeFrom() {
    return $this->ageFrom;
  }

  /**
   * Get the calendar from this event.
   */
  public function getCalendar() {
    return $this->calendar;
  }

  /**
   * Get the location from this event.
   */
  public function getLocation() {
    return $this->location;
  }

  /**
   * Get the organiser from this event.
   */
  public function getOrganiser() {
    return $this->organiser;
  }

  /**
   * Get the contact info from this event.
   */
  public function getContactInfo() {
    return $this->contactInfo;
  }

  /**
   * Get the maximum amount of participants.
   */
  public function getMaxParticipants() {
    return $this->maxParticipants;
  }

  /**
   * Get the booking period.
   */
  public function getBookingPeriod() {
    return $this->bookingPeriod;
  }

  /**
   * Set the publication date for this event.
   * @param string $date
   */
  public function setPublicationDate($date) {
    CultureFeed_Cdb_Data_Calendar::validateDate($date);
    $this->publicationDate = $date;
  }

  /**
   * Set the publication time for this event.
   * @param string $time
   */
  public function setPublicationTime($time) {
    CultureFeed_Cdb_Data_Calendar::validateTime($time);
    $this->publicationTime = $time;
  }

  /**
   * Set the minimum age for this event.
   * @param int $age
   *   Minimum age.
   *
   * @throws UnexpectedValueException
   */
  public function setAgeFrom($age) {

    if (!is_numeric($age)) {
      throw new UnexpectedValueException('Invalid age: ' . $age);
    }

    $this->ageFrom = $age;

  }

  /**
   * Set the calendar data for the event.
   * @param CultureFeed_Cdb_Data_Calendar $calendar
   *   Calendar data.
   */
  public function setCalendar(CultureFeed_Cdb_Data_Calendar $calendar) {
    $this->calendar = $calendar;
  }

  /**
   * Set the contact info from this event.
   * @param CultureFeed_Cdb_Data_Calendar $contactInfo
   *   Contact info to set.
   */
  public function setContactInfo(CultureFeed_Cdb_Data_ContactInfo $contactInfo) {
    $this->contactInfo = $contactInfo;
  }

  /**
   * Set the location from this event.
   * @param CultureFeed_Cdb_Data_Location $location
   *   Location to set.
   */
  public function setLocation(CultureFeed_Cdb_Data_Location $location) {
    $this->location = $location;
  }

  /**
   * Set the organiser from this event.
   * @param CultureFeed_Cdb_Data_Organiser $organiser
   *   Organiser to set.
   */
  public function setOrganiser(CultureFeed_Cdb_Data_Organiser $organiser) {
    $this->organiser = $organiser;
  }

  /**
   * Set the maximum amount of participants.
   */
  public function setMaxParticipants($maxParticipants) {
    $this->maxParticipants = $maxParticipants;
  }

  /**
   * Set the booking period.
   */
  public function setBookingPeriod(CultureFeed_Cdb_Data_Calendar_BookingPeriod $bookingPeriod) {
    $this->bookingPeriod = $bookingPeriod;
  }

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $eventElement = $dom->createElement('event');

    if ($this->ageFrom) {
      $eventElement->appendChild($dom->createElement('agefrom', $this->ageFrom));
    }

    if ($this->cdbId) {
      $eventElement->setAttribute('cdbid', $this->cdbId);
    }
    
    if ($this->private) {
      $eventElement->setAttribute('private', ($this->private) ? 'true' : 'false');
    }

    if ($this->externalId) {
      $eventElement->setAttribute('externalid', $this->externalId);
    }

    /*if ($this->publicationDate) {
      $eventElement->setAttribute('availablefrom', $this->publicationDate . $this->publicationTime);
    }*/

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
      $keywordElement = $dom->createElement('keywords');
      $keywordElement->appendChild($dom->createTextNode(implode(';', $this->keywords)));
      $eventElement->appendChild($keywordElement);
    }

    if ($this->location) {
      $this->location->appendToDOM($eventElement);
    }

    if ($this->organiser) {
      $this->organiser->appendToDOM($eventElement);
    }

    if ($this->maxParticipants) {
      $eventElement->appendChild($dom->createElement('maxparticipants', $this->maxParticipants));
    }

    if ($this->bookingPeriod) {
      $this->bookingPeriod->appendToDOM($eventelement);
    }

    if (!empty($this->relations)) {

      $relationsElement = $dom->createElement('eventrelations');

      foreach ($this->relations as $relation) {

        $relationElement = $dom->createElement('relatedproduction');
        $relationElement->appendChild($dom->createTextNode($relation->getTitle()));
        $relationElement->setAttribute('cdbid', $relation->getCdbid());

        $externalId = $relation->getExternalId();
        if ($externalId) {
          $relationElement->setAttribute('externalid', $relation->getExternalId());
        }

        $relationsElement->appendChild($relationElement);

      }

      $eventElement->appendChild($relationsElement);

    }

    $element->appendChild($eventElement);

  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return CultureFeed_Cdb_Item_Event
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    if (empty($xmlElement->calendar)) {
      throw new CultureFeed_Cdb_ParseException('Calendar missing for event element');
    }

    if (empty($xmlElement->categories)) {
      throw new CultureFeed_Cdb_ParseException('Categories missing for event element');
    }

    if (empty($xmlElement->contactinfo)) {
      throw new CultureFeed_Cdb_ParseException('Contact info missing for event element');
    }

    if (empty($xmlElement->eventdetails)) {
      throw new CultureFeed_Cdb_ParseException('Eventdetails missing for event element');
    }

    if (empty($xmlElement->location)) {
      throw new CultureFeed_Cdb_ParseException('Location missing for event element');
    }

    $event_attributes = $xmlElement->attributes();
    $event = new CultureFeed_Cdb_Item_Event();

    // Set ID.
    if (isset($event_attributes['cdbid'])) {
      $event->setCdbId((string)$event_attributes['cdbid']);
    }

    if (isset($event_attributes['availablefrom'])) {
      $event->setAvailableFrom((string)$event_attributes['availablefrom']);
    }

    if (isset($event_attributes['availableto'])) {
      $event->setAvailableTo((string)$event_attributes['availableto']);
    }

    if (isset($event_attributes['createdby'])) {
      $event->setCreatedBy((string)$event_attributes['createdby']);
    }

    if (isset($event_attributes['creationdate'])) {
      $event->setCreationDate((string)$event_attributes['creationdate']);
    }

    if (isset($event_attributes['private'])) {
      $event->setPrivate(filter_var((string)$event_attributes['private'], FILTER_VALIDATE_BOOLEAN));
    }

    if (isset($event_attributes['externalid'])) {
      $event->setExternalId((string)$event_attributes['externalid']);
    }

    if (isset($event_attributes['isparent'])) {
      $event->setIsParent(filter_var((string)$event_attributes['isparent'], FILTER_VALIDATE_BOOLEAN));
    }

    if (isset($event_attributes['lastupdated'])) {
      $event->setLastUpdated((string)$event_attributes['lastupdated']);
    }

    if (isset($event_attributes['lastupdatedby'])) {
      $event->setLastUpdatedBy((string)$event_attributes['lastupdatedby']);
    }

    if (isset($event_attributes['owner'])) {
      $event->setOwner((string)$event_attributes['owner']);
    }

    if (isset($event_attributes['pctcomplete'])) {
      $event->setPctComplete(floatval($event_attributes['pctcomplete']));
    }

    if (isset($event_attributes['published'])) {
      $event->setPublished(filter_var((string)$event_attributes['published'], FILTER_VALIDATE_BOOLEAN));
    }

    if (isset($event_attributes['validator'])) {
      $event->setValidator((string)$event_attributes['validator']);
    }

    if (isset($event_attributes['wfstatus'])) {
      $event->setWfStatus((string)$event_attributes['wfstatus']);
    }

    if (!empty($xmlElement->agefrom)) {
      $event->setAgeFrom((int)$xmlElement->agefrom);
    }

    // Set calendar information.
    $calendar_type = key($xmlElement->calendar);
    if ($calendar_type == 'permanentopeningtimes') {
      $event->setCalendar(CultureFeed_Cdb_Data_Calendar_Permanent::parseFromCdbXml($xmlElement->calendar));
    }
    elseif ($calendar_type == 'timestamps') {
      $event->setCalendar(CultureFeed_Cdb_Data_Calendar_TimestampList::parseFromCdbXml($xmlElement->calendar->timestamps));
    }
    elseif ($calendar_type == 'periods') {
      $event->setCalendar(CultureFeed_Cdb_Data_Calendar_PeriodList::parseFromCdbXml($xmlElement->calendar));
    }

    // Set categories
    $event->setCategories(CultureFeed_Cdb_Data_CategoryList::parseFromCdbXml($xmlElement->categories));

    // Set contact information.
    $event->setContactInfo(CultureFeed_Cdb_Data_ContactInfo::parseFromCdbXml($xmlElement->contactinfo));

    // Set event details.
    $event->setDetails(CultureFeed_Cdb_Data_EventDetailList::parseFromCdbXml($xmlElement->eventdetails));

    // Set location.
    $event->setLocation(CultureFeed_Cdb_Data_Location::parseFromCdbXml($xmlElement->location));

    // Set organiser
    if (!empty($xmlElement->organiser)) {
      $event->setOrganiser(CultureFeed_Cdb_Data_Organiser::parseFromCdbXml($xmlElement->organiser));
    }

    // Set max participants.
    if (!empty($xmlElement->maxparticipants)) {
      $event->setMaxParticipants((int)$xmlElement->maxparticipants);
    }

    // Set booking period.
    if (!empty($xmlElement->bookingperiod)) {
      $event->setBookingPeriod(CultureFeed_Cdb_Data_Calendar_BookingPeriod::parseFromCdbXml($xmlElement->bookingperiod));
    }

    // Set relations.
    if (!empty($xmlElement->eventrelations) && !empty($xmlElement->eventrelations->relatedproduction)) {

      foreach ($xmlElement->eventrelations->relatedproduction as $relatedProduction) {

        $attributes = $relatedProduction->attributes();

        $event->addRelation(new CultureFeed_Cdb_Item_Reference(
        	  (string)$attributes['cdbid'],
        		(string)$relatedProduction,
        		(string)$attributes['externalid']));

      }

    }

    // Set the keywords.
    if (!empty($xmlElement->keywords)) {
      $keywords = explode(';', $xmlElement->keywords);
      foreach ($keywords as $keyword) {
        $event->addKeyword($keyword);
      }
    }

    return $event;

  }

}
