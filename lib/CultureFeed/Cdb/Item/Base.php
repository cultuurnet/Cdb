<?php declare(strict_types=1);

abstract class CultureFeed_Cdb_Item_Base
{
    protected ?string $availableFrom = null;
    protected ?string $availableTo = null;
    protected ?CultureFeed_Cdb_Data_CategoryList $categories = null;
    protected ?string $cdbId = null;
    protected ?string $createdBy = null;
    protected ?string $creationDate = null;
    protected ?CultureFeed_Cdb_Data_DetailList $details = null;
    protected ?string $externalId = null;
    /** @var array<CultureFeed_Cdb_Data_Keyword> */
    protected array $keywords = [];
    protected ?string $lastUpdated = null;
    protected ?string $lastUpdatedBy = null;
    protected ?string $owner = null;
    protected ?bool $private = null;
    protected ?string $publisher = null;
    /** @var array<CultureFeed_Cdb_Item_Reference> */
    protected array $relations;
    protected ?string $wfStatus;

    protected static function parseKeywords(
        SimpleXMLElement $xmlElement,
        CultureFeed_Cdb_Item_Base $item
    ): void {
        if (@count($xmlElement->keywords)) {
            $keywordsString = trim($xmlElement->keywords);

            if ($keywordsString === '') {
                /**
                 * @var SimpleXMLElement $keywordElement
                 */
                foreach ($xmlElement->keywords->keyword as $keywordElement) {
                    $attributes = $keywordElement->attributes();
                    $visible =
                        !isset($attributes['visible']) ||
                        $attributes['visible'] == 'true';

                    $item->addKeyword(
                        new CultureFeed_Cdb_Data_Keyword(
                            (string) $keywordElement,
                            $visible
                        )
                    );
                }
            } else {
                $keywords = explode(';', $keywordsString);

                foreach ($keywords as $keyword) {
                    $item->addKeyword(trim($keyword));
                }
            }
        }
    }

    /**
     * @param string|CultureFeed_Cdb_Data_Keyword $keyword
     */
    public function addKeyword($keyword): void
    {
        // Keyword can be object (cdb 3.3) or string (< 3.3).
        if (!is_string($keyword)) {
            $this->keywords[$keyword->getValue()] = $keyword;
        } else {
            $this->keywords[$keyword] = new CultureFeed_Cdb_Data_Keyword(
                $keyword
            );
        }
    }

    protected static function parseCommonAttributes(CultureFeed_Cdb_Item_Base $item, SimpleXMLElement $xmlElement): void
    {
        $attributes = $xmlElement->attributes();

        if (isset($attributes['cdbid'])) {
            $item->setCdbId((string) $attributes['cdbid']);
        }

        if (isset($attributes['externalid'])) {
            $item->setExternalId((string) $attributes['externalid']);
        }

        if (isset($attributes['availablefrom'])) {
            $item->setAvailableFrom((string) $attributes['availablefrom']);
        }

        if (isset($attributes['availableto'])) {
            $item->setAvailableTo((string) $attributes['availableto']);
        }

        if (isset($attributes['createdby'])) {
            $item->setCreatedBy((string) $attributes['createdby']);
        }

        if (isset($attributes['creationdate'])) {
            $item->setCreationDate((string) $attributes['creationdate']);
        }

        if (isset($attributes['lastupdated'])) {
            $item->setLastUpdated((string) $attributes['lastupdated']);
        }

        if (isset($attributes['lastupdatedby'])) {
            $item->setLastUpdatedBy((string) $attributes['lastupdatedby']);
        }

        if (isset($attributes['owner'])) {
            $item->setOwner((string) $attributes['owner']);
        }

        if (isset($attributes['publisher'])) {
            $item->setPublisher((string) $attributes['publisher']);
        }

        if (isset($attributes['wfstatus'])) {
            $item->setWfStatus((string) $attributes['wfstatus']);
        }
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(string $id): void
    {
        $this->externalId = $id;
    }

    public function getCdbId(): ?string
    {
        return $this->cdbId;
    }

    public function setCdbId(string $id): void
    {
        $this->cdbId = $id;
    }

    public function isPrivate(): ?bool
    {
        return $this->private;
    }

    public function setPrivate(bool $private = true): void
    {
        $this->private = $private;
    }

    public function getLastUpdated(): ?string
    {
        return $this->lastUpdated;
    }

    public function setLastUpdated(string $value): void
    {
        $this->lastUpdated = $value;
    }

    public function getLastUpdatedBy(): ?string
    {
        return $this->lastUpdatedBy;
    }

    public function setLastUpdatedBy(string $author): void
    {
        $this->lastUpdatedBy = $author;
    }

    public function getAvailableFrom(): ?string
    {
        return $this->availableFrom;
    }

    public function setAvailableFrom(string $value): void
    {
        $this->availableFrom = $value;
    }

    public function getAvailableTo(): ?string
    {
        return $this->availableTo;
    }

    public function setAvailableTo(string $value): void
    {
        $this->availableTo = $value;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $author): void
    {
        $this->createdBy = $author;
    }

    public function getCreationDate(): ?string
    {
        return $this->creationDate;
    }

    public function setCreationDate(string $value): void
    {
        $this->creationDate = $value;
    }

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(string $owner): void
    {
        $this->owner = $owner;
    }

    public function getWfStatus(): ?string
    {
        return $this->wfStatus;
    }

    public function setWfStatus(string $status): void
    {
        $this->wfStatus = $status;
    }

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): void
    {
        $this->publisher = $publisher;
    }

    public function getCategories(): ?CultureFeed_Cdb_Data_CategoryList
    {
        return $this->categories;
    }

    public function setCategories(CultureFeed_Cdb_Data_CategoryList $categories): void
    {
        $this->categories = $categories;
    }

    public function getDetails(): ?CultureFeed_Cdb_Data_DetailList
    {
        return $this->details;
    }

    public function setDetails(CultureFeed_Cdb_Data_DetailList $details): void
    {
        $this->details = $details;
    }

    /**
     * @return array<string>|array<CultureFeed_Cdb_Data_Keyword>
     */
    public function getKeywords(bool $asObject = false): array
    {
        if ($asObject) {
            return $this->keywords;
        } else {
            $keywords = [];
            foreach ($this->keywords as $keyword) {
                $keywords[$keyword->getValue()] = $keyword->getValue();
            }
            return $keywords;
        }
    }

    /**
     * @return array<CultureFeed_Cdb_Item_Reference>
     */
    public function getRelations(): array
    {
        return $this->relations;
    }

    /**
     * @param string|CultureFeed_Cdb_Data_Keyword $keyword
     */
    public function deleteKeyword($keyword): void
    {
        if (!is_string($keyword)) {
            $keyword = $keyword->getValue();
        }

        if (!isset($this->keywords[$keyword])) {
            throw new Exception('Trying to remove a non-existing keyword.');
        }

        unset($this->keywords[$keyword]);
    }

    public function addRelation(CultureFeed_Cdb_Item_Reference $item): void
    {
        $this->relations[$item->getCdbId()] = $item;
    }

    public function deleteRelation(string $cdbid): void
    {
        if (!isset($this->relations[$cdbid])) {
            throw new Exception('Trying to remove a non-existing relation.');
        }

        unset($this->relations[$cdbid]);
    }
}
