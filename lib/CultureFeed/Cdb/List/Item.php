<?php

final class CultureFeed_Cdb_List_Item
{
    private string $externalId;
    private string $cdbId;
    private bool $private;
    private string $title;
    private string $shortDescription;
    private string $thumbnail;
    private string $address;
    private string $city;
    private string $zip;
    private string $location;
    private string $locationId;
    private string $calendarSummary;
    private string $coordinates;
    private string $type;
    private string $price;
    private string $priceDescription;
    private int $ageFrom;
    private string $performers;

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function getCdbId(): string
    {
        return $this->cdbId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function getCalendarSummary(): string
    {
        return $this->calendarSummary;
    }

    public function getCoordinates(): string
    {
        return $this->coordinates;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getPriceDescription(): string
    {
        return $this->priceDescription;
    }

    public function getAgeFrom(): int
    {
        return $this->ageFrom;
    }

    public function getPerfomers(): string
    {
        return $this->performers;
    }

    public function setExternalId(string $id): void
    {
        $this->externalId = $id;
    }

    public function setCdbId(string $id): void
    {
        $this->cdbId = $id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setPrivate(bool $private): void
    {
        $this->private = $private;
    }

    public function isPrivate(): bool
    {
        return $this->private;
    }

    public function setShortDescription(string $description): void
    {
        $this->shortDescription = $description;
    }

    public function setThumbnail(string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function setZip(string $zip): void
    {
        $this->zip = $zip;
    }

    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    public function setLocationId(string $locationId): void
    {
        $this->locationId = $locationId;
    }

    public function setCalendarSummary(string $calendarSummary): void
    {
        $this->calendarSummary = $calendarSummary;
    }

    public function setCoordinates(string $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function setPriceDescription(string $description): void
    {
        $this->priceDescription = $description;
    }

    public function setAgeFrom(int $ageFrom): void
    {
        $this->ageFrom = $ageFrom;
    }

    public function setPerformers(string $performers): void
    {
        $this->performers = $performers;
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_List_Item
    {
        $attributes = $xmlElement->attributes();
        $item = new self();

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
            $item->setAgeFrom((int) $attributes['agefrom']);
        }

        if (!empty($attributes['performers'])) {
            $item->setPerformers((string) $attributes['performers']);
        }

        return $item;
    }
}
