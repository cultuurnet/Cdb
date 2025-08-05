<?php

final class CultureFeed_Cdb_Item_Page implements CultureFeed_Cdb_IElement
{
    private string $id;
    private string $name;
    private bool $officialPage;
    /** @var array<string> */
    private array $categories;
    /** @var array<string> */
    private array $keywords;
    private string $description;
    private CultureFeed_Cdb_Data_Address_PhysicalAddress $address;
    private string $email;
    private string $telephone;
    /** @var array<string> */
    private array $links;
    private string $image;
    private string $cover;
    private bool $visible;
    private ?CultureFeed_Cdb_Data_PagePermissions $permissions = null;
    private string $tagline;
    private string $externalId;

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isOfficialPage(): bool
    {
        return $this->officialPage;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getCover(): string
    {
        return $this->cover;
    }

    /**
     * @return array<string>
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return array<string>
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAddress(): CultureFeed_Cdb_Data_Address_PhysicalAddress
    {
        return $this->address;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @return array<string>
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    public function getVisibility(): bool
    {
        return $this->visible == 'true';
    }

    public function getPermissions(): ?CultureFeed_Cdb_Data_PagePermissions
    {
        return $this->permissions;
    }

    public function isVisible(): bool
    {
        return $this->getVisibility();
    }

    public function getTagline(): string
    {
        return $this->tagline;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setOfficialPage(bool $officialPage): void
    {
        $this->officialPage = $officialPage;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function setCover(string $cover): void
    {
        $this->cover = $cover;
    }

    /**
     * @param array<string> $categories
     */
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @param array<string> $keywords
     */
    public function setKeywords(array $keywords): void
    {
        $this->keywords = $keywords;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setAddress(CultureFeed_Cdb_Data_Address_PhysicalAddress $address): void
    {
        $this->address = $address;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @param string[] $links
     */
    public function setLinks(array $links): void
    {
        $this->links = $links;
    }

    public function setVisibility(bool $visible): void
    {
        $this->visible = $visible;
    }

    public function setPermissions(CultureFeed_Cdb_Data_PagePermissions $permissions): void
    {
        $this->permissions = $permissions;
    }

    public function setTagline(string $tagline): void
    {
        $this->tagline = $tagline;
    }

    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function appendToDOM(DOMElement $element): void
    {
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Item_Page
    {
        if (empty($xmlElement->uid)) {
            throw new CultureFeed_Cdb_ParseException(
                'Uid missing for page element'
            );
        }

        if (empty($xmlElement->name)) {
            throw new CultureFeed_Cdb_ParseException(
                'Name missing for page element'
            );
        }

        $page = new self();

        $page->setId((string) $xmlElement->uid);
        $page->setName((string) $xmlElement->name);
        $page->setOfficialPage(
            filter_var(
                (string) $xmlElement->officialPage,
                FILTER_VALIDATE_BOOLEAN
            )
        );

        $categories = array();
        if (!empty($xmlElement->categoryIds->categoryId)) {
            foreach ($xmlElement->categoryIds->categoryId as $category) {
                $categories[] = (string) $category;
            }
        }
        $page->setCategories($categories);

        $keywords = array();
        if (!empty($xmlElement->keywords->keyword)) {
            foreach ($xmlElement->keywords->keyword as $keyword) {
                $keywords[] = (string) $keyword;
            }
        }
        $page->setKeywords($keywords);

        if (!empty($xmlElement->description)) {
            $page->setDescription((string) $xmlElement->description);
        }

        if (!empty($xmlElement->image)) {
            $page->setImage((string) $xmlElement->image);
        }

        if (!empty($xmlElement->cover)) {
            $page->setCover((string) $xmlElement->cover);
        }

        if (!empty($xmlElement->visible)) {
            $page->setVisibility((bool) $xmlElement->visible);
        }

        $address = new CultureFeed_Cdb_Data_Address_PhysicalAddress();
        $addressElement = $xmlElement->address;
        $has_address = false;
        if (!empty($addressElement->city)) {
            $address->setCity((string) $addressElement->city);
            $has_address = true;
        }

        if (!empty($addressElement->street)) {
            $address->setStreet((string) $addressElement->street);
            $has_address = true;
        }

        if (!empty($addressElement->zip)) {
            $address->setZip((string) $addressElement->zip);
            $has_address = true;
        }

        if (!empty($addressElement->country)) {
            $address->setCountry((string) $addressElement->country);
            $has_address = true;
        }

        if (!empty($addressElement->lat) && !empty($addressElement->lon)) {
            $coordinates = $addressElement->lat . '-' . $addressElement->lon;
            if ($coordinates != '0.0-0.0') {
                $address->setGeoInformation(
                    new CultureFeed_Cdb_Data_Address_GeoInformation(
                        (string) $addressElement->lon,
                        (string) $addressElement->lat
                    )
                );
                $has_address = true;
            }
        }

        if ($has_address) {
            $page->setAddress($address);
        }

        if (!empty($xmlElement->contactInfo->email)) {
            $page->setEmail((string) $xmlElement->contactInfo->email);
        }
        if (!empty($xmlElement->contactInfo->telephone)) {
            $page->setTelephone((string) $xmlElement->contactInfo->telephone);
        }

        $links = array();
        if (!empty($xmlElement->links)) {
            foreach ($xmlElement->links->children() as $link) {
                $url = (string) $link;
                if (empty($url)) {
                    continue;
                }

                $http = strpos($url, 'http://') === 0;
                $https = strpos($url, 'https://') === 0;

                // Make sure http(s) is in front of the url.
                if (!($http || $https)) {
                    $url = 'http://' . $url;
                }
                $links[$link->getName()] = $url;
            }
        }
        $page->setLinks($links);

        $page->setPermissions(
            CultureFeed_Cdb_Data_PagePermissions::parseFromCdbXml(
                $xmlElement->permissions
            )
        );

        $page->setTagline((string) $xmlElement->tagline);

        $page->setExternalId((string) $xmlElement->externalid);

        return $page;
    }
}
