<?php

/**
 * @class
 * Class for the representation of list item on the culturefeed.
 */
class CultureFeed_Cdb_List_Item
{
    /**
     * External id from the item.
     *
     * @var string
     */
    protected $externalId;

    /**
     * cdbId from the item.
     * @var string
     */
    protected $cdbId;

    /**
     * Is item private.
     * @var bool
     */
    protected $private;

    /**
     * Title from the item
     * @var string
     */
    protected $title;

    /**
     * Short description from an item.
     *
     * @var string
     */
    protected $shortDescription;

    /**
     * Thumbnail from the item.
     * @var string
     */
    protected $thumbnail;

    /**
     * Address from the item
     * @var string
     */
    protected $address;

    /**
     * City from the item.
     * @var string
     */
    protected $city;

    /**
     * Zip code from the location of the item.
     * @var string
     */
    protected $zip;

    /**
     * Location from the item.
     * @var string
     */
    protected $location;

    /**
     * Location ID from the items location.
     * @var string
     */
    protected $locationId;

    /**
     * Calendar summary from this item.
     * @var string
     */
    protected $calendarSummary;

    /**
     * Coördinates from this item.
     * @var string
     */
    protected $coordinates;

    /**
     * item type.
     * @var string
     */
    protected $type;

    /**
     * Price for the item.
     * @var string
     */
    protected $price;

    /**
     * Price description for the item.
     */
    protected $priceDescription;

    /**
     * Minimum age for the item.
     * @var int
     */
    protected $ageFrom;

    /**
     * Performers from this item.
     * @var string
     */
    protected $performers;

    /**
     * Get the external ID from this item.
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * Get the Cdbid from this item.
     * @return string
     */
    public function getCdbId()
    {
        return $this->cdbId;
    }

    /**
     * Get the title from this item.
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the short description from current item.
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Get the thumbnail image from current item.
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * Get the address from this item.
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get the city from this item.
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get the zip code from this item.
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Get the location from this item.
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Get the location id from this item.
     * @return string
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * Get the calendar summary from this item.
     * @return string
     */
    public function getCalendarSummary()
    {
        return $this->calendarSummary;
    }

    /**
     * Get the coördinates from this item.
     * @return string
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Get the type of item.
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the price from this item.
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get the price description from this item.
     * @return string
     */
    public function getPriceDescription()
    {
        return $this->priceDescription;
    }

    /**
     * Get the minimum age for this item.
     * @return number
     */
    public function getAgeFrom()
    {
        return $this->ageFrom;
    }

    /**
     * Return the performers from this event.
     * @return string
     */
    public function getPerfomers()
    {
        return $this->performers;
    }

    /**
     * Set the external id from this item.
     *
     * @param string $id
     *   ID to set.
     */
    public function setExternalId($id)
    {
        $this->externalId = $id;
    }

    /**
     * Set the cdbid from this item.
     *
     * @param string $id
     */
    public function setCdbId($id)
    {
        $this->cdbId = $id;
    }

    /**
     * Set the title from this item.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Set item private.
     *
     * @param bool $private
     */
    public function setPrivate($private)
    {
        $this->private = $private;
    }

    /**
     * Set the short description from current item.
     */
    public function setShortDescription($description)
    {
        $this->shortDescription = $description;
    }

    /**
     * Set the thumbnail image from current item.
     *
     * @param string $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * Set the address from this item.
     *
     * @param string $address
     *   Address to set.
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Set the city from this item.
     *
     * @param string $city
     *   City to set.
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * Set the zip code from this item.
     *
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * Set the location from this item.
     *
     * @param string $location
     *   Location to set.
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * Set the location ID from this item.
     *
     * @param string $locationId
     *   Location ID to set.
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * Set the calendar summary from this item.
     *
     * @param string $calendarSummary
     *   Summary to set.
     */
    public function setCalendarSummary($calendarSummary)
    {
        $this->calendarSummary = $calendarSummary;
    }

    /**
     * Set the coördinates from this item.
     *
     * @param string $coordinates
     *   Coordinates to set.
     */
    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;
    }

    /**
     * Set the type of item.
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Set the price of the item.
     *
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Set the price description from this item.
     *
     * @param string $description
     */
    public function setPriceDescription($description)
    {
        $this->priceDescription = $description;
    }

    /**
     * Set the minimum age for this item.
     *
     * @param int $ageFrom
     */
    public function setAgeFrom($ageFrom)
    {
        $this->ageFrom = $ageFrom;
    }

    /**
     * Set the performers from this item.
     *
     * @param string $performers
     */
    public function setPerformers($performers)
    {
        $this->performers = $performers;
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_List_Item
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {

        $attributes = $xmlElement->attributes();
        $item = new self();

        // Set ID.
        $item->setCdbId((string) $attributes['cidn']);

        if (!empty($attributes['private'])) {
            $item->setPrivate((bool) $attributes['private']);
        }

        if (!empty($attributes['externalid'])) {
            $item->setExternalId((string) $attributes['externalid']);
        }

        $item->setTitle((string) $attributes['title']);

        if (!empty($attributes['shortdescription'])) {
            $item->setShortDescription(
                (string) $attributes['shortdescription']
            );
        }

        if (!empty($attributes['thumbnail'])) {
            $item->setThumbnail((string) $attributes['thumbnail']);
        }

        if (!empty($attributes['address'])) {
            $item->setAddress((string) $attributes['address']);
        }

        if (!empty($attributes['city'])) {
            $item->setCity((string) $attributes['city']);
        }

        if (!empty($attributes['zip'])) {
            $item->setZip((string) $attributes['zip']);
        }

        if (!empty($attributes['latlng'])) {
            $item->setCoordinates((string) $attributes['latlng']);
        }

        if (!empty($attributes['location'])) {
            $item->setLocation((string) $attributes['location']);
        }

        if (!empty($attributes['locationid'])) {
            $item->setLocationId((string) $attributes['locationid']);
        }

        if (!empty($attributes['calendarsummary'])) {
            $item->setCalendarSummary((string) $attributes['calendarsummary']);
        }

        if (!empty($attributes['itemtype'])) {
            $item->setType((string) $attributes['itemtype']);
        }

        if (!empty($attributes['price'])) {
            $item->setPrice((string) $attributes['price']);
        }

        if (!empty($attributes['pricedescription'])) {
            $item->setPriceDescription(
                (string) $attributes['pricedescription']
            );
        }

        if (!empty($attributes['agefrom'])) {
            $item->setAgeFrom((string) $attributes['agefrom']);
        }

        if (!empty($attributes['performers'])) {
            $item->setPerformers((string) $attributes['performers']);
        }

        return $item;
    }
}
