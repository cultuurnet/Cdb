<?php

class CultureFeed_Cdb_Data_File  implements CultureFeed_Cdb_IElement {

  /**
   * Constants for the different allowed file types.
   */
  const FILE_TYPE_JPEG = 'jpeg';
  const FILE_TYPE_GIF = 'gif';
  const FILE_TYPE_PNG = 'png';
  const FILE_TYPE_MP3 = 'mp3';
  const FILE_TYPE_QUICK_TIME = 'qt';
  const FILE_TYPE_MOV = 'mov';
  const FILE_TYPE_WMV = 'wmv';
  const FILE_TYPE_WAV = 'wav';
  const FILE_TYPE_RM = 'rm';
  const FILE_TYPE_AVI = 'avi';
  const FILE_TYPE_MPG = 'mpg';
  const FILE_TYPE_SWF = 'swf';
  const FILE_TYPE_PDF = 'pdf';
  const FILE_TYPE_RTF = 'rtf';
  const FILE_TYPE_DOC = 'doc';
  const FILE_TYPE_XLS = 'xls';
  const FILE_TYPE_TXT = 'txt';
  const FILE_TYPE_HTML = 'html(1)';
  const FILE_TYPE_ZIP = 'zip';
  const FILE_TYPE_UNKNOWN = 'onbepaald';

  /**
   * Constants for the media types.
   */
  const MEDIA_TYPE_PHOTO = 'photo';
  const MEDIA_TYPE_VIDEO = 'video';
  const MEDIA_TYPE_WEBRESOURCE = 'webresource';
  const MEDIA_TYPE_CULTUREFEED_PAGE = 'culturefeed-page';
  const MEDIA_TYPE_RESERVATIONS = 'reservations';

  /**
   * Constants for relation types.
   */
  const REL_TYPE_ORGANISER = 'organiser';

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
   * Relation type.
   * @var string
   */
  protected $relationType;

  /**
   * Link to the file.
   * @var string
   */
  protected $hLink;

  /**
   * Description or review of the file.
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
   * Return the cdbid of this file.
   * @return string
   */
  public function getCdbid() {
    return $this->cdbid;
  }

  /**
   * Return the creation date of this file.
   */
  public function getCreationDate() {
    return $this->creationDate;
  }

  /**
   * Get the media type of this file.
   * @return string
   */
  public function getMediaType() {
    return $this->mediaType;
  }

  /**
   * Get the channel of this file.
   * @return string
   */
  public function getChannel() {
    return $this->channel;
  }

  /**
   * Get the title of this file.
   * @return string
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * Get the copyright information of this file.
   * @return string
   */
  public function getCopyright() {
    return $this->copyright;
  }

  /**
   * Get the filename of this file.
   * @return string
   */
  public function getFileName() {
    return $this->fileName;
  }

  /**
   * Get the file type of this file.
   * @return string
   */
  public function getFileType() {
    return $this->fileType;
  }

  /**
   * Get the relation type of this file.
   */
  public function getRelationType() {
    return $this->relationType;
  }

  /**
   * Get the link to this file.
   * @return string
   */
  public function getHLink() {
    return $this->hLink;
  }

  /**
   * Get the description or review of this file.
   * @return string
   */
  public function getPlainText() {
    return $this->plainText;
  }

  /**
   * Set the main status of this file.
   * @param bool Main status to set.
   */
  public function setMain($main) {
    $this->main = $main;
  }

  /**
   * Set the private status of this file.
   * @param bool Private status to set.
   */
  public function setPrivate($private) {
    $this->private = $private;
  }

  /**
   * Set the cdbid of this file.
   * @param string $cdbid Cdbid to set.
   */
  public function setCdbid($cdbid) {
    $this->cdbid = $cdbid;
  }

  /**
   * Set the creation date of this file.
   * @param string $date Date to set.
   */
  public function setCreationDate($date) {
    $this->date = $date;
  }

  /**
   * Set the media type of this file.
   * @param string $type Type to set.
   */
  public function setMediaType($type) {
    $this->mediaType = $type;
  }

  /**
   * Set the source channel of this file.
   * @param string $channel Channel to set.
   */
  public function setChannel($channel) {
    $this->channel = $channel;
  }

  /**
   * Set the title of this file.
   * @param string $title Title to set.
   */
  public function setTitle($title) {
    $this->title = $title;
  }

  /**
   * Set the copyright information of this file.
   * @param string $copyright Copyright to set.
   */
  public function setCopyright($copyright) {
    $this->copyright = $copyright;
  }

  /**
   * Set the filename of this file.
   * @param string $fileName filename to set.
   */
  public function setFileName($fileName) {
    $this->fileName = $fileName;
  }

  /**
   * Set the filetype of this file.
   * @param string $fileType filetype to set.
   */
  public function setFileType($fileType) {
    $this->fileType = $fileType;
  }

  /**
   * Set the relation type of this file.
   * @param string $relationType
   */
  public function setRelationType($relationType) {
    $this->relationType = $relationType;
  }

  /**
   * Set the link to this file.
   * @param string $link Link to set.
   */
  public function setHLink($link) {
    $this->hLink = $link;
  }

  /**
   * Set the description / review text of this file.
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
      $fileNameElement = $dom->createElement('filename');
      $fileNameElement->appendChild($dom->createTextNode($this->fileName));
      $fileElement->appendChild($fileNameElement);
    }

    if (!empty($this->fileType)) {
      $fileElement->appendChild($dom->createElement('filetype', $this->fileType));
    }

    if (!empty($this->relationType)) {
      $fileElement->appendChild($dom->createElement('reltype', $this->relationType));
    }

    if (!empty($this->hLink)) {
      $hLinkElement = $dom->createElement('hlink');
      $hLinkElement->appendChild($dom->createTextNode($this->hLink));
      $fileElement->appendChild($hLinkElement);
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
      $titleElement = $dom->createElement('title');
      $titleElement->appendChild($dom->createTextNode($this->title));
      $fileElement->appendChild($titleElement);
    }

    $element->appendChild($fileElement);

  }

  /**
   * Parse a new object from a given cdbxml element.
   * @param SimpleXMLElement $xmlElement
   *   XML to parse.
   * @throws CultureFeed_Cdb_ParseException
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

    if (!empty($xmlElement->reltype)) {
      $file->relationType = (string)$xmlElement->reltype;
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
