<?php

class CultureFeed_Cdb_Data_File  implements CultureFeed_Cdb_IElement {

  const MEDIA_TYPE_PHOTO = 'photo';

  const MEDIA_TYPE_WEBRESOURCE = 'webresource';

  /**
   * Is the current file a main file.
   * @var bool
   */
  protected $main = FALSE;

  /**
   * Cdbid from the file.
   * @var string
   */
  protected $cdbid;

  /**
   * Creation date from the file.
   * @var string
   */
  protected $creationDate;

  /**
   * The aggregation channel from this file.
   * @var string
   */
  protected $channel;

  /**
   * Is the current private or not.
   * @var bool
   */
  protected $private = FALSE;

  /**
   * Media type from the file.
   * @var string
   */
  protected $mediaType;

  /**
   * Title from the file.
   * @var string
   */
  protected $title;

  /**
   * Copyright information from the file.
   * @var string
   */
  protected $copyright;

  /**
   * Filename from the file.
   * @var string
   */
  protected $fileName;

  /**
   * File type.
   * @var string
   */
  protected $fileType;

  /**
   * Link to the file.
   * @var string
   */
  protected $hLink;

  /**
   * Description or review from the file.
   * @var string
   */
  protected $plainText;

  /**
   * Is the current file a main file.
   * @return $bool
   */
  public function isMain() {
    return $this->main;
  }

  /**
   * Is the current file private.
   * @return $bool
   */
  public function isPrivate() {
    return $this->private;
  }

  /**
   * Return the cdbid from this file.
   * @return string
   */
  public function getCdbid() {
    return $this->cdbid;
  }

  /**
   * Return the creation date from this file.
   */
  public function getCreationDate() {
    return $this->creationDate;
  }

  /**
   * Get the media type from this file.
   * @return string
   */
  public function getMediaType() {
    return $this->mediaType;
  }

  /**
   * Get the channel from this file.
   * @return string
   */
  public function getChannel() {
    return $this->channel;
  }

  /**
   * Get the title from this file.
   * @return string
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * Get the copyright information from this file.
   * @return string
   */
  public function getCopyright() {
    return $this->copyright;
  }

  /**
   * Get the filename from this file.
   * @return string
   */
  public function getFileName() {
    return $this->fileName;
  }

  /**
   * Get the file type for this file.
   * @return string
   */
  public function getFileType() {
    return $this->fileType;
  }

  /**
   * Get the link to this file.
   * @return string
   */
  public function getHLink() {
    return $this->hLink;
  }

  /**
   * Get the description or review from this file.
   * @return string
   */
  public function getPlainText() {
    return $this->plainText;
  }

  /**
   * Set the main status from this file.
   * @param bool Main status to set.
   */
  public function setMain($main) {
    $this->main = $main;
  }

  /**
   * Set the private status from this file.
   * @param bool Private status to set.
   */
  public function setPrivate($private) {
    $this->private = $private;
  }

  /**
   * Set the cdbid from this file.
   * @param string $cdbid Cdbid to set.
   */
  public function setCdbid($cdbid) {
    $this->cdbid = $cdbid;
  }

  /**
   * Set the creation date from this file.
   * @param string $date Date to set.
   */
  public function setCreationDate($date) {
    $this->date = $date;
  }

  /**
   * Set the media type from this file.
   * @param string $type Type to set.
   */
  public function setMediaType($type) {
    $this->mediaType = $type;
  }

  /**
   * Set the source channel from this file.
   * @param string $channel Channel to set.
   */
  public function setChannel($channel) {
    $this->channel = $channel;
  }

  /**
   * Set the title from this file.
   * @param string $title Title to set.
   */
  public function setTitle($title) {
    $this->title = $title;
  }

  /**
   * Set the copyright information from this file.
   * @param string $copyright Copyright to set.
   */
  public function setCopyright($copyright) {
    $this->copyright = $copyright;
  }

  /**
   * Set the filename from this file.
   * @param string $fileName filename to set.
   */
  public function setFileName($fileName) {
    $this->fileName = $fileName;
  }

  /**
   * Set the filetype from this file.
   * @param string $fileType filetype to set.
   */
  public function setFileType($fileType) {
    $this->fileType = $fileType;
  }

  /**
   * Set the link to this file.
   * @param string $link Link to set.
   */
  public function setHLink($link) {
    $this->hLink = $link;
  }

  /**
   * Set the description / review text from this file.
   */
  public function setPlainText($text) {
    $this->plainText = $text;
  }

  /**
   * Appends the current object to the passed DOM tree.
   *
   * @param DOMElement $element
   *   The DOM tree to append to.
   */
  public function appendToDOM(DOMElement $element) {

    $dom = $element->ownerDocument;

    $fileElement = $dom->createElement('file');

    if (!empty($this->cdbid)) {
      $fileElement->setAttribute('cdbid', $this->cdbid);
    }

    if (!empty($this->channel)) {
      $fileElement->setAttribute('channel', $this->channel);
    }
    
    if (!empty($this->copyright)) {
      $copyrightElement = $dom->createElement('copyright');
      $copyrightElement->appendChild($dom->createTextNode($this->copyright));
      $fileElement->appendChild($copyrightElement);
    }
    
    if (!empty($this->creationDate)) {
      $fileElement->setAttribute('creationdate', $this->creationDate);
    }
    
    if (!empty($this->fileName)) {
      $fileElement->appendChild($dom->createElement('filename', $this->fileName));
    }

    if (!empty($this->fileType)) {
      $fileElement->appendChild($dom->createElement('filetype', $this->fileName));
    }

    if (!empty($this->hLink)) {
      $fileElement->appendChild($dom->createElement('hlink', $this->hLink));
    }

    if ($this->main) {
      $fileElement->setAttribute('main', 'true');
    }

    if (!empty($this->mediaType)) {
      $fileElement->appendChild($dom->createElement('mediatype', $this->mediaType));
    }
    
    if (!empty($this->plainText)) {
      $plainTextElement = $dom->createElement('plaintext');
      $plainTextElement->appendChild($dom->createTextNode($this->plainText));
      $fileElement->appendChild($plainTextElement);
    }
    
    if ($this->private) {
      $fileElement->setAttribute('private', 'true');
    }

    if (!empty($this->title)) {
      $fileElement->appendChild($dom->createElement('title', $this->title));
    }

    $element->appendChild($fileElement);

  }

  /**
   * Parse a new object from a given cdbxml element.
   * @param SimpleXMLElement $xmlElement
   *   XML to parse.
   * @throws CultureFeed_ParseException
   */
  public static function parseFromCdbXml(SimpleXMLElement $xmlElement) {

    $file = new self();

    $attributes = $xmlElement->attributes();
    if (isset($attributes['main'])) {
      $file->main = $attributes['main'] == 'true';
    }

    if (isset($attributes['cdbid'])) {
      $file->cdbid = $attributes['cdbid'];
    }

    if (isset($attributes['creationdate'])) {
      $file->creationDate = $attributes['creationdate'];
    }

    if (isset($attributes['channel'])) {
      $file->channel = $attributes['channel'];
    }

    if (isset($attributes['private'])) {
      $file->private = $attributes['private'] == 'true';
    }

    if (!empty($xmlElement->copyright)) {
      $file->copyright = (string)$xmlElement->copyright;
    }

    if (!empty($xmlElement->filename)) {
      $file->fileName = (string)$xmlElement->filename;
    }

    if (!empty($xmlElement->filetype)) {
      $file->fileType = (string)$xmlElement->filetype;
    }

    if (!empty($xmlElement->hlink)) {
      $file->hLink = (string)$xmlElement->hlink;
    }

    if (!empty($xmlElement->plaintext)) {
      $file->plainText = (string)$xmlElement->plaintext;
    }

    if (!empty($xmlElement->mediatype)) {
      $file->mediaType = (string)$xmlElement->mediatype;
    }

    if (!empty($xmlElement->title)) {
      $file->title = (string)$xmlElement->title;
    }

    return $file;

  }

}
