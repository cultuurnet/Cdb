<?php

/**
 * @class
 * Representation of a contactinfo element in the cdb xml.
 */
class CultureFeed_Cdb_Data_ContactInfo implements CultureFeed_Cdb_IElement {

  /**
   * List of addresses.
   * @var array
   */
  protected $addresses = array();

  /**
   * List of phones.
   * @var array
   */
  protected $phones = array();

  /**
   * List of mails.
   * @var CultureFeed_Cdb_Data_Mail[]
   */
  protected $mails = array();

  /**
   * List of urls.
   * @var array
   */
  protected $urls = array();

  /**
   * Get the list of addresses.
   *
   * @return array
   */
  public function getAddresses() {
    return $this->addresses;
  }

  /**
   * Get the list of phones.
   */
  public function getPhones() {
    return $this->phones;
  }

  /**
   * Get the list of mails.
   *
   * @return CultureFeed_Cdb_Data_Mail[]
   */
  public function getMails() {
    return $this->mails;
  }

  /**
   * Get the list of urls.
   */
  public function getUrls() {
    return $this->urls;
  }

  /**
   * Add an address to the address list.
   * @param CultureFeed_Cdb_Data_Address $address
   */
  public function addAddress(CultureFeed_Cdb_Data_Address $address) {
    $this->addresses[] = $address;
  }

  /**
   * Remove an address at a given index.
   * @param int $index
   *   Index to remove.
   * @throws Exception
   */
  public function removeAddress($index) {

    if (!isset($this->addresses[$index])) {
      throw new Exception('Trying to remove an unexisting address.');
    }

    unset($this->addresses[$index]);

  }

  /**
   * Add a phone to the phone list.
   * @param CultureFeed_Cdb_Data_Phone $phone
   */
  public function addPhone(CultureFeed_Cdb_Data_Phone $phone) {
    $this->phones[] = $phone;
  }

  /**
   * Remove a phone at a given index.
   * @param int $index
   *   Index to remove.
   * @throws Exception
   */
  public function removePhone($index) {

    if (!isset($this->phones[$index])) {
      throw new Exception('Trying to remove an unexisting phone.');
    }

    unset($this->phones[$index]);

  }

  /**
   * Delete all phones
   */
  public function deletePhones() {
    $this->phones = array();
  }

  /**
   * Add a mail to the mail list.
   * @param CultureFeed_Cdb_Data_Mail $mail
   */
  public function addMail(CultureFeed_Cdb_Data_Mail $mail) {
    $this->mails[] = $mail;
  }

  /**
   * Remove a mail at a given index.
   * @param int $index
   *   Index to remove.
   * @throws Exception
   */
  public function removeMail($index) {

    if (!isset($this->mails[$index])) {
      throw new Exception('Trying to remove an unexisting mail.');
    }

    unset($this->mails[$index]);

  }

  /**
   * Delete all mails
   */
  public function deleteMails() {
    $this->mails = array();
  }

  /**
   * Add an url to the url list.
   * @param CultureFeed_Cdb_Data_Url $url
   */
  public function addUrl(CultureFeed_Cdb_Data_Url $url) {
    $this->urls[] = $url;
  }

  /**
   * Remove an url at a given index.
   * @param int $index
   *   Index to remove.
   * @throws Exception
   */
  public function removeUrl($index) {

    if (!isset($this->urls[$index])) {
      throw new Exception('Trying to remove an unexisting url.');
    }

    unset($this->urls[$index]);

  }

  /**
   * Delete all urls
   */
  public function deleteUrls() {
    $this->mails = array();
  }

  /**
   * Get the reservation contact info.
   * @return array()
   */
  public function getReservationInfo() {

    $info = array();

    foreach ($this->urls as $url) {
      if ($url->isForReservations()) {
        $info['url'][] = $url->getUrl();
      }
    }

    foreach ($this->phones as $phone) {
      if ($phone->isForReservations()) {
        $info['phone'][] = $phone->getNumber();
      }
    }

    foreach ($this->mails as $mail) {
      if ($mail->isForReservations()) {
        $info['mails'][] = $mail->getMailAddress();
      }
    }

    return $info;

  }

  /**
   * Get the main contact info.
   * @return array()
   */
  public function getMainInfo() {

    $info = array();

    foreach ($this->urls as $url) {
      if ($url->isMain()) {
        $info['url'][] = $url->getUrl();
      }
    }

    foreach ($this->phones as $phone) {
      if ($phone->isMain()) {
        $info['phone'][] = $phone->getNumber();
      }
    }

    foreach ($this->mails as $mail) {
      if ($mail->isMain()) {
        $info['mails'][] = $mail->getAddress();
      }
    }

    return $info;

  }

  /**
   * Get the reservation url.
   */
  public function getReservationUrl() {
    foreach ($this->urls as $url) {
      if ($url->isForReservations()) {
        return $url->getUrl();
      }
    }
  }

  /**
   * @see CultureFeed_Cdb_IElement::appendToDOM()
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $contactElement = $dom->createElement('contactinfo');

    foreach ($this->addresses as $address) {
      $address->appendToDom($contactElement);
    }

    foreach ($this->mails as $mail) {
      $mail->appendToDom($contactElement);
    }

    foreach ($this->phones as $phone) {
      $phone->appendToDom($contactElement);
    }

    foreach ($this->urls as $url) {
      $url->appendToDom($contactElement);
    }

    $element->appendChild($contactElement);

  }

  /**
   * @see CultureFeed_Cdb_IElement::parseFromCdbXml(SimpleXMLElement $xmlElement)
   * @return CultureFeed_Cdb_Data_ContactInfo
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    $contactInfo = new CultureFeed_Cdb_Data_ContactInfo();

    // Address from contact information.
    if (!empty($xmlElement->address)) {
      $contactInfo->addAddress(CultureFeed_Cdb_Data_Address::parseFromCdbXml($xmlElement->address));
    }

    // Mails.
    if (!empty($xmlElement->mail)) {
      foreach ($xmlElement->mail as $mailElement) {
        $contactInfo->addMail(CultureFeed_Cdb_Data_Mail::parseFromCdbXml($mailElement));
      }
    }

    // Phone numbers.
    if (!empty($xmlElement->phone)) {
      foreach ($xmlElement->phone as $phoneElement) {
        $contactInfo->addPhone(CultureFeed_Cdb_Data_Phone::parseFromCdbXml($phoneElement));
      }
    }

    // Urls.
    if (!empty($xmlElement->url)) {
      foreach ($xmlElement->url as $urlElement) {
        $contactInfo->addUrl(CultureFeed_Cdb_Data_Url::parseFromCdbXml($urlElement));
      }
    }

    return $contactInfo;

  }

}
