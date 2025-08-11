<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_Category implements CultureFeed_Cdb_IElement
{
    public const CATEGORY_TYPE_EVENT_TYPE = 'eventtype';
    public const CATEGORY_TYPE_ACTOR_TYPE = 'actortype';
    public const CATEGORY_TYPE_THEME = 'theme';
    public const CATEGORY_TYPE_PUBLICSCOPE = 'publicscope';
    public const CATEGORY_TYPE_EDUCATION_FIELD = 'educationfield';
    public const CATEGORY_TYPE_EDUCATION_LEVEL = 'educationlevel';
    public const CATEGORY_TYPE_FACILITY = 'facility';
    public const CATEGORY_TYPE_TARGET_AUDIENCE = 'targetaudience';
    /** @deprecated use CATEGORY_TYPE_TARGET_AUDIENCE instead. */
    public const CATEGORY_TYPE_TARGET_AUDIANCE = 'targetaudience';
    public const CATEGORY_TYPE_FLANDERS_REGION = 'flandersregion';
    public const CATEGORY_TYPE_UMV = 'umv';

    private string $type;
    private string $id;
    private string $name;

    public function __construct(string $type, string $id, string $name)
    {
        $this->type = $type;
        $this->id = $id;
        $this->name = $name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $categoryElement = $dom->createElement('category');
        $categoryElement->appendChild($dom->createTextNode($this->name));
        $categoryElement->setAttribute('catid', $this->id);
        $categoryElement->setAttribute('type', $this->type);

        $element->appendChild($categoryElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_Category
    {
        $attributes = $xmlElement->attributes();
        if (!isset($attributes['type'])) {
            throw new CultureFeed_Cdb_ParseException();
        }

        if (!isset($attributes['catid'])) {
            throw new CultureFeed_Cdb_ParseException();
        }

        return new CultureFeed_Cdb_Data_Category(
            (string) $attributes['type'],
            (string) $attributes['catid'],
            (string) $xmlElement
        );
    }
}
