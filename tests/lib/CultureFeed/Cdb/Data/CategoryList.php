<?php

/**
 * @class
 * Representation of a list of categories in the cdb xml.
 */
class CultureFeed_Cdb_Data_CategoryList implements CultureFeed_Cdb_IElement, Iterator
{
    /**
     * Current position in the list.
     * @var int
     */
    protected $position = 0;

    /**
     * The list of categories.
     * @var CultureFeed_Cdb_Data_Category[]
     */
    protected $categories = array();

    /**
     * Add a new category to the list.
     *
     * @param CultureFeed_Cdb_Data_Category $category
     *   Category to add.
     */
    public function add(CultureFeed_Cdb_Data_Category $category)
    {
        $this->categories[] = $category;
    }

    /**
     * Delete a given category of the list.
     * @deprecated Using the delete method will result in an issue when iterating,
     * because the index aka position gets a gap and the iteration stops on the gap.
     */
    public function delete($key)
    {
        unset($this->categories[$key]);
    }

    /**
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @see Iterator::current()
     */
    public function current()
    {
        return $this->categories[$this->position];
    }

    /**
     * @see Iterator::key()
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @see Iterator::next()
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @see Iterator::valid()
     */
    public function valid()
    {
        return isset($this->categories[$this->position]);
    }

    /**
     * Get all the categories from this list from a given type.
     *
     * @param $type string
     *   Type of categories to get.
     */
    public function getCategoriesByType($type)
    {

        $categories = array();
        foreach ($this->categories as $category) {
            if ($category->getType() == $type) {
                $categories[] = $category;
            }
        }

        return $categories;
    }

    /**
     * Does the given category id exists in this list.
     *
     * @param  string $id
     *   Category id. Ex 0.57.0.0.0
     *
     * @return bool
     */
    public function hasCategory($id)
    {

        foreach ($this->categories as $category) {
            if ($category->getId() == $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * @see CultureFeed_Cdb_IElement::appendToDOM()
     */
    public function appendToDOM(DOMElement $element)
    {

        $dom = $element->ownerDocument;

        $categoriesElement = $dom->createElement('categories');
        foreach ($this as $category) {
            $category->appendToDom($categoriesElement);
        }

        $element->appendChild($categoriesElement);
    }

    /**
     * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement
     *     $xmlElement)
     * @return CultureFeed_Cdb_Data_CategoryList
     */
    public static function parseFromCdbXml(SimpleXMLElement $xmlElement)
    {

        $categoryList = new CultureFeed_Cdb_Data_CategoryList();

        if (!empty($xmlElement->category)) {
            foreach ($xmlElement->category as $categoryElement) {
                $category = CultureFeed_Cdb_Data_Category::parseFromCdbXml(
                    $categoryElement
                );
                if ($category) {
                    $categoryList->add($category);
                }
            }
        }

        return $categoryList;
    }
}
