<?php

class CultureFeed_Cdb_Data_File  implements CultureFeed_Cdb_IElement {

  const MEDIA_TYPE_PHOTO = 'photo';

  const MEDIA_TYPE_WEBRESOURCE = 'webresource';

  /**
   * @var string
   */
  protected $mediaType;

  /**
   * @var string
   */
  protected $title;

  /**
   * @var string
   */
  protected $copyright;

  protected $fileName;

  protected $fileType;

  protected $hLink;

  /**
   * Appends the current object to the passed DOM tree.
   *
   * @param DOMElement $element
   *   The DOM tree to append to.
   */
  public function appendToDOM(DOMElement $element) {
    // TODO: Implement appendToDOM() method.
  }

  /**
   * Parse a new object from a given cdbxml element.
   * @param SimpleXMLElement $xmlElement
   *   XML to parse.
   * @throws CultureFeed_ParseException
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {
    $file = new self();

    if (!empty($xmlElement->copyright)) {
      $file->copyright = (string)$xmlElement->copyright;
    }

    if (!empty($xmlElement->filename)) {
      $file->fileName = (string)$xmlElement->filename;
    }

    if (!empty($xmlElement->filetype)) {
      $file->filetype = (string)$xmlElement->filetype;
    }

    if (!empty($xmlElement->hlink)) {
      $file->hLink = (string)$xmlElement->hlink;
    }

    if (!empty($xmlElement->mediatype)) {
      $file->mediaType = (string)$xmlElement->mediatype;
    }

    if (!empty($xmlElement->title)) {
      $file->title = (string)$xmlElement->title;
    }

    return $file;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getMediaType() {
    return $this->mediaType;
  }

  public function getHLink() {
    return $this->hLink;
  }

  public function getFileType() {
    return $this->fileType;
  }

  public function getFileName() {
    return $this->fileName;
  }

  public function getCopyright() {
    return $this->copyright;
  }
}
