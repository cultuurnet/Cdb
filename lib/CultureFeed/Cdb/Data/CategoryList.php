<?php

declare(strict_types=1);

/**
 * @implements Iterator<CultureFeed_Cdb_Data_Category>
 */
final class CultureFeed_Cdb_Data_CategoryList implements CultureFeed_Cdb_IElement, Iterator
{
    private int $position = 0;
    /**
     * @var CultureFeed_Cdb_Data_Category[]
     */
    private array $categories = [];

    public function add(CultureFeed_Cdb_Data_Category $category): void
    {
        $this->categories[] = $category;
    }

    /**
    * @deprecated Using the delete method will result in an issue when iterating,
    * because the index aka position gets a gap and the iteration stops on the gap.
    */
    public function delete(int $key): void
    {
        unset($this->categories[$key]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function current(): CultureFeed_Cdb_Data_Category
    {
        return $this->categories[$this->position];
    }

    public function key(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->categories[$this->position]);
    }

    /**
     * @return array<CultureFeed_Cdb_Data_Category>
     */
    public function getCategoriesByType(string $type): array
    {
        $categories = [];
        foreach ($this->categories as $category) {
            if ($category->getType() == $type) {
                $categories[] = $category;
            }
        }

        return $categories;
    }

    public function hasCategory(string $id): bool
    {
        foreach ($this->categories as $category) {
            if ($category->getId() == $id) {
                return true;
            }
        }

        return false;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $categoriesElement = $dom->createElement('categories');
        foreach ($this as $category) {
            $category->appendToDom($categoriesElement);
        }

        $element->appendChild($categoriesElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_CategoryList
    {
        $categoryList = new CultureFeed_Cdb_Data_CategoryList();

        if (!empty($xmlElement->category)) {
            foreach ($xmlElement->category as $categoryElement) {
                try {
                    $category = CultureFeed_Cdb_Data_Category::parseFromCdbXml($categoryElement);
                    $categoryList->add($category);
                } catch (CultureFeed_Cdb_ParseException $exception) {
                }
            }
        }

        return $categoryList;
    }
}
