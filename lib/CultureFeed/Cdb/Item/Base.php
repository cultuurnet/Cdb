<?php

/**
 * @class
 * Abstract base class for the representation of an item on the culturefeed.
 */
abstract class CultureFeed_Cdb_Item_Base
{
    /**
     * @var string
     */
    protected $availableFrom;

    /**
     * @var string
     */
    protected $availableTo;

    /**
     * Categories from the item.
     * @var CultureFeed_Cdb_Data_CategoryList
     */
    protected $categories;

    /**
     * cdbId from the item.
     * @var string
     */
    protected $cdbId;

    /**
     * @var string
     */
    protected $createdBy;

    /**
     * @var string
     */
    protected $creationDate;

    /**
     * Details from the item.
     *
     * @var CultureFeed_Cdb_Data_DetailList
     */
    protected $details;

    /**
     * External id from the item.
     *
     * @var string
     */
    protected $externalId;

    /**
     * External url from the item.
     *
     * @var string
     */
    protected $externalUrl;

    /**
     * Keywords from the item
     *
     * @var CultureFeed_Cdb_Data_Keyword[] List with keywords.
     */
    protected $keywords = array();

    /**
     * @var string
     */
    protected $lastUpdated;

    /**
     * @var string
     */
    protected $lastUpdatedBy;

    /**
     * Owner of this item.
     * @var string
     */
    protected $owner;

    /**
     * Is item private
     * @var bool
     */
    protected $private = null;

    /**
     * Publisher of this item.
     * @var string
     */
    protected $publisher;

    /**
     * Relations from the item.
     * @var CultureFeed_Cdb_Item_Reference[] List with related items.
     */
    protected $relations;

    /**
     * @var string
     */
    protected $wfStatus;

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
     * @param CultureFeed_Cdb_Item_Base $item
     * @param SimpleXMLElement $xmlElement
     */
    protected static function parseCommonAttributes(CultureFeed_Cdb_Item_Base $item, SimpleXMLElement $xmlElement)
    {
        $attributes = $xmlElement->attributes();

        if (isset($attributes['cdbid'])) {
            $item->setCdbId((string) $attributes['cdbid']);
        }

        if (isset($attributes['externalid'])) {
            $item->setExternalId((string) $attributes['externalid']);
        }

        if (isset($attributes['externalurl'])) {
            $item->setExternalUrl((string) $attributes['externalurl']);
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

        if (isset($attributes['private'])) {
            $item->setPrivate(
                filter_var(
                    (string) $attributes['private'],
                    FILTER_VALIDATE_BOOLEAN
                )
            );
        }
    }

    /**
     * @param DOMElement $element
     */
    protected function appendCommonAttributesToDOM(
        DOMElement $element,
        $cdbScheme = '3.2'
    ) {
        if ($this->availableFrom) {
            $element->setAttribute('availablefrom', $this->availableFrom);
        }

        if ($this->availableTo) {
            $element->setAttribute('availableto', $this->availableTo);
        }

        if ($this->cdbId) {
            $element->setAttribute('cdbid', $this->cdbId);
        }

        if ($this->createdBy) {
            $element->setAttribute('createdby', $this->createdBy);
        }

        if ($this->creationDate) {
            $element->setAttribute('creationdate', $this->creationDate);
        }

        if ($this->externalId) {
            $element->setAttribute('externalid', $this->externalId);
        }

        if ($this->externalUrl && version_compare($cdbScheme, '3.3', '>=')) {
            $element->setAttribute('externalurl', $this->externalUrl);
        }

        if (isset($this->lastUpdated)) {
            $element->setAttribute('lastupdated', $this->lastUpdated);
        }

        if (isset($this->lastUpdatedBy)) {
            $element->setAttribute('lastupdatedby', $this->lastUpdatedBy);
        }

        if (isset($this->owner)) {
            $element->setAttribute('owner', $this->owner);
        }

        if (isset($this->private)) {
            $element->setAttribute(
                'private',
                $this->private ? 'true' : 'false'
            );
        }

        if (isset($this->wfStatus)) {
            $element->setAttribute('wfstatus', $this->wfStatus);
        }

        if ($this->publisher) {
            $element->setAttribute('publisher', $this->publisher);
        }
    }

    /**
     * Parses keywords from cdbxml.
     *
     * @param CultureFeed_Cdb_Item_Base $item
     * @param SimpleXMLElement $xmlElement
     */
    protected static function parseKeywords(
        CultureFeed_Cdb_Item_Base $item,
        SimpleXMLElement $xmlElement
    ) {
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
     * @param DOMElement $element
     * @param string $cdbScheme
     */
    protected function appendKeywordsToDOM(
        DOMElement $element,
        $cdbScheme = '3.2'
    ) {
        $dom = $element->ownerDocument;

        if (count($this->keywords) > 0) {
            $keywordsElement = $dom->createElement('keywords');
            if (version_compare($cdbScheme, '3.3', '>=')) {
                foreach ($this->keywords as $keyword) {
                    $keyword->appendToDOM($keywordsElement);
                }
                $element->appendChild($keywordsElement);
            } else {
                $keywords = array();
                foreach ($this->keywords as $keyword) {
                    $keywords[$keyword->getValue()] = $keyword->getValue();
                }
                $keywordsElement->appendChild(
                    $dom->createTextNode(implode(';', $keywords))
                );
                $element->appendChild($keywordsElement);
            }
        }
    }

    /**
     * @param CultureFeed_Cdb_Item_Base $item
     * @param SimpleXMLElement $xmlElement
     *
     * @throws CultureFeed_Cdb_ParseException
     */
    protected static function parseCategories(
        CultureFeed_Cdb_Item_Base $item,
        SimpleXMLElement $xmlElement
    ) {
        if (empty($xmlElement->categories)) {
            $elementName = $xmlElement->getName();

            throw new CultureFeed_Cdb_ParseException(
                "Categories missing for {$elementName} element"
            );
        }

        $item->setCategories(
            CultureFeed_Cdb_Data_CategoryList::parseFromCdbXml(
                $xmlElement->categories
            )
        );
    }

    /**
     * @param DOMElement $element
     * @param string $cdbScheme
     */
    protected function appendCategoriesToDOM(
        DOMElement $element,
        $cdbScheme = '3.2'
    ) {
        if ($this->categories) {
            $this->categories->appendToDOM($element);
        }
    }

    /**
     * Get the external ID from this item.
     */
    public function getExternalId()
    {
        return $this->externalId;
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
     * Get the external url from this item.
     *
     * @return string
     */
    public function getExternalUrl()
    {
        return $this->externalUrl;
    }

    /**
     * Set the external url from this item.
     *
     * @param string $url
     *   Url to set.
     */
    public function setExternalUrl($url)
    {
        $this->externalUrl = $url;
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
     * Set the cdbid from this item.
     *
     * @param string $id
     */
    public function setCdbId($id)
    {
        $this->cdbId = $id;
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
     * Set if item is private.
     *
     * @param bool $private
     */
    public function setPrivate($private = true)
    {
        $this->private = $private;
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

    /**
     * @return string
     */
    public function getAvailableFrom()
    {
        return $this->availableFrom;
    }

    /**
     * @param string $value
     */
    public function setAvailableFrom($value)
    {
        $this->availableFrom = $value;
    }

    /**
     * @return string
     */
    public function getAvailableTo()
    {
        return $this->availableTo;
    }

    /**
     * @param string $value
     */
    public function setAvailableTo($value)
    {
        $this->availableTo = $value;
    }

    /**
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param string $author
     */
    public function setCreatedBy($author)
    {
        $this->createdBy = $author;
    }

    /**
     * @return string
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param string $value
     */
    public function setCreationDate($value)
    {
        $this->creationDate = $value;
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     */
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
     * Get the categories from this item.
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set the categories from this item.
     *
     * @param CultureFeed_Cdb_Data_CategoryList $categories
     *   Categories to set.
     */
    public function setCategories(CultureFeed_Cdb_Data_CategoryList $categories)
    {
        $this->categories = $categories;
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
     * Set the details from this item.
     *
     * @param CultureFeed_Cdb_Data_DetailList $details
     *   Detail information from the current item.
     */
    public function setDetails(CultureFeed_Cdb_Data_DetailList $details)
    {
        $this->details = $details;
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

        $this->keywords = array_filter(
            $this->keywords,
            function (CultureFeed_Cdb_Data_Keyword $itemKeyword) use ($keyword) {
                return strcmp(mb_strtolower($itemKeyword->getValue(), 'UTF-8'), mb_strtolower($keyword, 'UTF-8')) !== 0;
            }
        );
    }

    /**
     * Add a relation to the current item.
     *
     * @param CultureFeed_Cdb_Item_Reference $item
     */
    public function addRelation(CultureFeed_Cdb_Item_Reference $item)
    {
        $this->relations[$item->getCdbId()] = $item;
    }

    /**
     * Delete a relation from the item.
     *
     * @param string $cdbid Cdbid to delete
     */
    public function deleteRelation($cdbid)
    {

        if (!isset($this->relations[$cdbid])) {
            throw new Exception('Trying to remove a non-existing relation.');
        }

        unset($this->relations[$cdbid]);
    }
}
