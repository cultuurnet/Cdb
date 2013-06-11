<?php

/**
 * @class
 * Representation of a page on the culturefeed.
 * This is not a real cdb item at the moment
 */
class CultureFeed_Cdb_Item_Page implements CultureFeed_Cdb_IElement {

  /**
   * Id of the page.
   * @var string
   */
  protected $id;

  /**
   * Name of the page.
   * @var string
   */
  protected $name;

  /**
   * Categories of the page.
   * @var string[]
   */
  protected $categories;

  /**
   * Description of the page.
   * @var string
   */
  protected $description;

  /**
   * Address for this page.
   * @var CultureFeed_Cdb_Data_Address_PhysicalAddress
   */
  protected $address;

  /**
   * Email of this page.
   * @var string
   */
  protected $email;

  /**
   * Telephone of this page.
   * @var string
   */
  protected $telephone;

  /**
   * Links of this page.
   * @var string[]
   */
  protected $links;

  /**
   * Image of this page.
   * @var String url
   */
  protected $image;

  /**
   * Indicates whether the page is visible.
   */
  protected $visible;

  /**
   * Permissions of a page.
   * @var CultureFeed_Cdb_Data_PagePermissions
   */
  protected $permissions = NULL;

  /**
   * Get the id of this page.
   * @return string
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Get the name of this page.
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Get the image of this page.
   * @return string
   */
  public function getImage() {
    return $this->image;
  }

  /**
   * Get the categories of this page.
   * @return string[]
   */
  public function getCategories() {
    return $this->categories;
  }

  /**
   * Get the description of this page.
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * Get the address.
   * @return CultureFeed_Cdb_Data_Address_PhysicalAddress
   */
  public function getAddress() {
    return $this->address;
  }

  /**
   * Get the email.
   * @return string
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * Get the telephone
   * @return string
   */
  public function getTelephone() {
    return $this->telephone;
  }

  /**
   * Get the links.
   * @return string[]
   */
  public function getLinks() {
    return $this->links;
  }

  /**
   * Get the visibility.
   * @return Boolean
   */
  public function getVisibility() {
    return $this->visible == "true" ? true : false;
  }

  /**
   * Get the permissions.
   * @return CultureFeed_Cdb_Data_PagePermissions
   */
  public function getPermissions() {
    return $this->permissions;
  }

  /**
   * Alias of getVisibility.
   * @return Boolean
   */
  public function isVisible() {
    return $this->getVisibility();
  }

  /**
   * Set the id.
   * @param string $id
   */
  public function setId($id) {
    $this->id = $id;
  }

  /**
   * Set the name of this page.
   * @param string $name
   */
  public function setName($name) {
    $this->name = $name;
  }

  /**
   * Set the image of this page.
   * @param string $image
   */
  public function setImage($image) {
    $this->image = $image;
  }

  /**
   * Set the categories of the page.
   * @param array $categories
   */
  public function setCategories($categories) {
    $this->categories = $categories;
  }

  /**
   * Set the description of the page.
   * @param string $description
   */
  public function setDescription($description) {
    $this->description = $description;
  }

  /**
   * Set the address.
   * @param CultureFeed_Cdb_Data_Address_PhysicalAddress $address
   */
  public function setAddress(CultureFeed_Cdb_Data_Address_PhysicalAddress $address) {
    $this->address = $address;
  }

  /**
   * Set the email.
   * @param string
   */
  public function setEmail($email) {
    $this->email = $email;
  }

  /**
   * Set the telephone.
   * @param string $telephone
   */
  public function setTelephone($telephone) {
    $this->telephone = $telephone;
  }

  /**
   * Set the links.
   * @param string[] $links
   */
  public function setLinks($links) {
    $this->links = $links;
  }

  /**
   * Set the visibility.
   * @param Boolean $visible
   */
  public function setVisibility($visible) {
    $this->visible = $visible;
  }

  /**
   * Set the permissions.
   * @param CultureFeed_Cdb_Data_PagePermissions $permissions
   */
  public function setPermissions($permissions) {
    $this->permissions = $permissions;
  }

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMElement $element) {
  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return CultureFeed_Cdb_Item_Page
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    if (empty($xmlElement->uid)) {
      throw new CultureFeed_Cdb_ParseException('Uid missing for page element');
    }

    if (empty($xmlElement->name)) {
      throw new CultureFeed_Cdb_ParseException('Name missing for page element');
    }

    $page = new self();

    // Set ID + name.
    $page->setId((string) $xmlElement->uid);
    $page->setName((string) $xmlElement->name);

    // Set categories
    $categories = array();
    if (!empty($xmlElement->categoryIds->categoryId)) {
      foreach ($xmlElement->categoryIds->categoryId as $category) {
        $categories[] = (string) $category;
      }
    }
    $page->setCategories($categories);

    // Set description.
    if (!empty($xmlElement->description)) {
      $page->setDescription((string) $xmlElement->description);
    }

    // Set the image.
    if (!empty($xmlElement->image)) {
      $page->setImage((string) $xmlElement->image);
    }

    // Set the visibility.
    if (!empty($xmlElement->visible)) {
      $page->setVisibility((string) $xmlElement->visible);
    }

    // Set address.
    $address = new CultureFeed_Cdb_Data_Address_PhysicalAddress();
    $addressElement = $xmlElement->address;
    $has_address = FALSE;
    if (!empty($addressElement->city)) {
      $address->setCity((string) $addressElement->city);
      $has_address = TRUE;
    }

    if (!empty($addressElement->street)) {
      $address->setStreet((string) $addressElement->street);
      $has_address = TRUE;
    }

    if (!empty($addressElement->zip)) {
      $address->setZip((string) $addressElement->zip);
      $has_address = TRUE;
    }

    if (!empty($addressElement->country)) {
      $address->setCountry((string) $addressElement->country);
      $has_address = TRUE;
    }

    if (!empty($addressElement->lat) && !empty($addressElement->lon)) {

      $coordinates = $addressElement->lat . '-' . $addressElement->lon;
      if ($coordinates != '0.0-0.0') {
        $address->setGeoInformation(new CultureFeed_Cdb_Data_Address_GeoInformation((string) $addressElement->lat, (string) $addressElement->lon));
        $has_address = TRUE;
      }

    }

    if ($has_address) {
      $page->setAddress($address);
    }

    // Set contact info.
    if (!empty($xmlElement->contactInfo->email)) {
      $page->setEmail((string) $xmlElement->contactInfo->email);
    }
    if (!empty($xmlElement->contactInfo->telephone)) {
      $page->setTelephone((string) $xmlElement->contactInfo->telephone);
    }

    // Set links.
    $links = array();
    if (!empty($xmlElement->links)) {
      foreach ($xmlElement->links->children() as $link) {

        $url = (string) $link;
        if (empty($url)) {
          continue;
        }

        // Make sure http is in front of the url.
        if (strpos($url, 'http://') !== 0) {
          $url = 'http://' . $url;
        }
        $links[$link->getName()] = $url;

      }
    }
    $page->setLinks($links);

    // Set the permissions.
    $page->setPermissions(CultureFeed_Cdb_Data_PagePermissions::parseFromCdbXml($xmlElement->permissions));

    return $page;

  }

}
