<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Item_Reference
{
    private string $title = '';
    private string $cdbId = '';
    private string $externalId = '';

    public function __construct(string $cdbId, string $title = '', string $externalId = '')
    {
        $this->cdbId = $cdbId;
        $this->title = $title;
        $this->externalId = $externalId;
    }

    public function getCdbId(): string
    {
        return $this->cdbId;
    }

    public function setCdbId(string $cdbId): void
    {
        $this->cdbId = $cdbId;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
