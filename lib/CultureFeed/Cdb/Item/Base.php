<?php

/**
 * @class
 * Abstract base class for the representation of an item on the culturefeed.
 */
abstract class CultureFeed_Cdb_Item_Base
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
     * Is item private
     * @var bool
     */
    protected $private = null;

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
     * @var string
     */
    protected $lastUpdated;

    /**
     * @var string
     */
    protected $lastUpdatedBy;

    /**
     * Categories from the item.
     * @var CultureFeed_Cdb_Data_CategoryList
     */
    protected $categories;

    /**
     * Details from the item.
     *
     * @var CultureFeed_Cdb_Data_DetailList
     */
    protected $details;

    /**
     * Keywords from the item
     *
     * @var CultureFeed_Cdb_Data_Keyword[] List with keywords.
     */
    protected $keywords = array();

    /**
     * Relations from the item.
     * @var CultureFeed_Cdb_Item_Reference[] List with related items.
     */
    protected $relations;

    /**
     * Publisher of this item.
     * @var string
     */
    protected $publisher;

    /**
     * Owner of this item.
     * @var string
     */
    protected $owner;

    /**
     * @var string
     */
    protected $wfStatus;

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
     * Get if item is private.
     * @return bool
     */
    public function isPrivate()
    {
        return $this->private;
    }

    /**
     * @return string
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    /**
     * @param string $value
     */
    public function setLastUpdated($value)
    {
        $this->lastUpdated = $value;
    }

    /**
     * @return string
     */
    public function getLastUpdatedBy()
    {
        return $this->lastUpdatedBy;
    }

    /**
     * @param string $author
     */
    public function setLastUpdatedBy($author)
    {
        $this->lastUpdatedBy = $author;
    }


    public function setAvailableFrom($value)
    {
        $this->availableFrom = $value;
    }

    public function getAvailableFrom()
    {
        return $this->availableFrom;
    }

    public function setAvailableTo($value)
    {
        $this->availableTo = $value;
    }

    public function getAvailableTo()
    {
        return $this->availableTo;
    }

    public function setCreatedBy($author)
    {
        $this->createdBy = $author;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setCreationDate($value)
    {
        $this->creationDate = $value;
    }

    public function getCreationDate()
    {
        return $this->creationDate;
    }

    public function getOwner()
    {
        return $this->owner;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getWfStatus()
    {
        return $this->wfStatus;
    }

    /**
     * @param string $status
     */
    public function setWfStatus($status)
    {
        $this->wfStatus = $status;
    }

    /**
     * Set the publisher.
     *
     * @param string $publisher
     *   The publisher.
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;
    }

    /**
     * Get the publisher.
     *
     * @return string
     *   The publisher.
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Get the categories from this item.
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Get the details from this item.
     *
     * @return CultureFeed_Cdb_Data_DetailList
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Get the keywords from this item.
     *
     * @param bool $asObject
     *   Return keywords as objects or values.
     *
     * @return array
     *   The keywords.
     */
    public function getKeywords($asObject = false)
    {

        if ($asObject) {
            return $this->keywords;
        } else {
            $keywords = array();
            foreach ($this->keywords as $keyword) {
                $keywords[$keyword->getValue()] = $keyword->getValue();
            }
            return $keywords;
        }

    }

    /**
     * Get the relations from this item.
     */
    public function getRelations()
    {
        return $this->relations;
    }

    /**
     * Set the external id from this item.
     * @param string $id
     *   ID to set.
     */
    public function setExternalId($id)
    {
        $this->externalId = $id;
    }

    /**
     * Set the cdbid from this item.
     * @param string $id
     */
    public function setCdbId($id)
    {
        $this->cdbId = $id;
    }

    /**
     * Set if item is private.
     * @param bool $private
     */
    public function setPrivate($private = true)
    {
        $this->private = $private;
    }

    /**
     * Set the categories from this item.
     * @param CultureFeed_Cdb_Data_CategoryList $categories
     *   Categories to set.
     */
    public function setCategories(CultureFeed_Cdb_Data_CategoryList $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Set the details from this item.
     * @param CultureFeed_Cdb_Data_DetailList $details
     *   Detail information from the current item.
     */
    public function setDetails(CultureFeed_Cdb_Data_DetailList $details)
    {
        $this->details = $details;
    }

    /**
     * Add a keyword to this item.
     *
     * @param string|CultureFeed_Cdb_Data_Keyword $keyword
     *   Add a keyword.
     */
    public function addKeyword($keyword)
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

    /**
     * Delete a keyword from this item.
     *
     * @param string|CultureFeed_Cdb_Data_Keyword $keyword
     *   Delete keyword as object or value.
     *
     * @throws Exception
     */
    public function deleteKeyword($keyword)
    {

        if (!is_string($keyword)) {
            $keyword = $keyword->getValue();
        }

        if (!isset($this->keywords[$keyword])) {
            throw new Exception('Trying to remove a non-existing keyword.');
        }

        unset($this->keywords[$keyword]);

    }

    /**
     * Add a relation to the current item.
     * @param CultureFeed_Cdb_Item_Reference $item
     */
    public function addRelation(CultureFeed_Cdb_Item_Reference $item)
    {
        $this->relations[$item->getCdbId()] = $item;
    }

    /**
     * Delete a relation from the item.
     * @param string $cdbid Cdbid to delete
     */
    public function deleteRelation($cdbid)
    {

        if (!isset($this->relations[$cdbid])) {
            throw new Exception('Trying to remove a non-existing relation.');
        }

        unset($this->relations[$cdbid]);

    }

    /**
     * Parses keywords from cdbxml.
     * @param SimpleXMLElement $xmlElement
     * @param CultureFeed_Cdb_Item_Base $item
     */
    protected static function parseKeywords(
        SimpleXMLElement $xmlElement,
        CultureFeed_Cdb_Item_Base $item
    ) {
        if (@count($xmlElement->keywords)) {
            $keywordsString = trim($xmlElement->keywords);

            if ($keywordsString === '') {
                /** @var SimpleXMLElement $keywordElement */
                foreach ($xmlElement->keywords->keyword as $keywordElement) {
                    $attributes = $keywordElement->attributes();
                    $visible =
                        !isset($attributes['visible']) ||
                        $attributes['visible'] == 'true';

                    $item->addKeyword(
                        new CultureFeed_Cdb_Data_Keyword(
                            (string)$keywordElement,
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
     * @param CultureFeed_Cdb_Item_Base $item
     * @param SimpleXMLElement $xmlElement
     */
    protected static function parseCommonAttributes(CultureFeed_Cdb_Item_Base $item, SimpleXMLElement $xmlElement)
    {
        $attributes = $xmlElement->attributes();

        if (isset($attributes['cdbid'])) {
            $item->setCdbId((string)$attributes['cdbid']);
        }

        if (isset($attributes['externalid'])) {
            $item->setExternalId((string)$attributes['externalid']);
        }

        if (isset($attributes['availablefrom'])) {
            $item->setAvailableFrom((string)$attributes['availablefrom']);
        }

        if (isset($attributes['availableto'])) {
            $item->setAvailableTo((string)$attributes['availableto']);
        }

        if (isset($attributes['createdby'])) {
            $item->setCreatedBy((string)$attributes['createdby']);
        }

        if (isset($attributes['creationdate'])) {
            $item->setCreationDate((string)$attributes['creationdate']);
        }

        if (isset($attributes['lastupdated'])) {
            $item->setLastUpdated((string)$attributes['lastupdated']);
        }

        if (isset($attributes['lastupdatedby'])) {
            $item->setLastUpdatedBy((string)$attributes['lastupdatedby']);
        }

        if (isset($attributes['owner'])) {
            $item->setOwner((string)$attributes['owner']);
        }

        if (isset($attributes['publisher'])) {
            $item->setPublisher((string)$attributes['publisher']);
        }

        if (isset($attributes['wfstatus'])) {
            $item->setWfStatus($attributes['wfstatus']);
        }
    }
}
