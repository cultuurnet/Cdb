<?php

abstract class CultureFeed_Cdb_Data_Detail
{
    protected ?string $title = null;
    protected ?string $shortDescription = null;
    protected ?string $longDescription = null;
    protected ?string $language = null;
    protected ?CultureFeed_Cdb_Data_Media $media = null;
    protected ?CultureFeed_Cdb_Data_Price $price = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function getLongDescription(): ?string
    {
        return $this->longDescription;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getMedia(): ?CultureFeed_Cdb_Data_Media
    {
        return $this->media;
    }

    public function getPrice(): ?CultureFeed_Cdb_Data_Price
    {
        return $this->price;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setShortDescription(string $description): void
    {
        $this->shortDescription = $description;
    }

    public function setLongDescription(string $description): void
    {
        $this->longDescription = $description;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function setPrice(CultureFeed_Cdb_Data_Price $price): void
    {
        $this->price = $price;
    }

    public function setMedia(CultureFeed_Cdb_Data_Media $media): void
    {
        $this->media = $media;
    }
}
