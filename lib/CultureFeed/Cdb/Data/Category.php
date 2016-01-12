<?php

/**
 * @class
 * Representation of a category element in the cdb xml.
 */
class CultureFeed_Cdb_Data_Category implements CultureFeed_Cdb_IElement
{
    /**
     * Category types.
     */
    const CATEGORY_TYPE_EVENT_TYPE = 'eventtype';
    const CATEGORY_TYPE_ACTOR_TYPE = 'actortype';
    const CATEGORY_TYPE_THEME = 'theme';
    const CATEGORY_TYPE_PUBLICSCOPE = 'publicscope';
    const CATEGORY_TYPE_EDUCATION_FIELD = 'educationfield';
    const CATEGORY_TYPE_EDUCATION_LEVEL = 'educationlevel';
    const CATEGORY_TYPE_FACILITY = 'facility';
    const CATEGORY_TYPE_TARGET_AUDIENCE = 'targetaudience';
    /**
     * @deprecated use CATEGORY_TYPE_TARGET_AUDIENCE instead.
     */
    const CATEGORY_TYPE_TARGET_AUDIANCE = 'targetaudience';
    const CATEGORY_TYPE_FLANDERS_REGION = 'flandersregion';

    /**
     * Type of category.
     * @var string
     */
    protected $type;

    /**
     * ID from the category.
     * @var string
     */
    protected $id;

    /**
     * Name from the category.
     * @var string
     */
    protected $name;

    /**
     * Construct a new category.
     *
     * @param string $type
     *   Type of category.
     * @param $id
     *   ID from the category.
     * @param $name
     *   Name from the category.
     */
    public function __construct($type, $id, $name)
    {
        $this->type = $type;
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Get the type of category.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the ID from the category.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the name from the category.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the type of category.
     *
     * @param string $type
     *   Type of category.
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Set the ID from the category.
     *
     * @param string $id
     *   Id from the category.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set the name from the category.
     *
     * @param string $name
     *   Name from the category.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMElement $element)
    {

        $dom = $element->ownerDocument;

        $categoryElement = $dom->createElement('category');
        $categoryElement->appendChild($dom->createTextNode($this->name));
        $categoryElement->setAttribute('catid', $this->id);
        $categoryElement->setAttribute('type', $this->type);

        $element->appendChild($categoryElement);
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_Category
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {

        $attributes = $xmlElement->attributes();
        if (!isset($attributes['type'])) {
            return;
            //throw new CultureFeed_Cdb_ParseException("Category type missing for category element");
        }

        if (!isset($attributes['catid'])) {
            return;
            //throw new CultureFeed_Cdb_ParseException("Category ID missing for category element");
        }

        return new CultureFeed_Cdb_Data_Category(
            (string) $attributes['type'],
            (string) $attributes['catid'],
            (string) $xmlElement
        );
    }
}
