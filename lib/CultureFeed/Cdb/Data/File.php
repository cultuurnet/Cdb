<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Data_File implements CultureFeed_Cdb_IElement
{
    public const FILE_TYPE_JPEG = 'jpeg';
    public const FILE_TYPE_GIF = 'gif';
    public const FILE_TYPE_PNG = 'png';
    public const FILE_TYPE_MP3 = 'mp3';
    public const FILE_TYPE_QUICK_TIME = 'qt';
    public const FILE_TYPE_MOV = 'mov';
    public const FILE_TYPE_WMV = 'wmv';
    public const FILE_TYPE_WAV = 'wav';
    public const FILE_TYPE_RM = 'rm';
    public const FILE_TYPE_AVI = 'avi';
    public const FILE_TYPE_MPG = 'mpg';
    public const FILE_TYPE_SWF = 'swf';
    public const FILE_TYPE_PDF = 'pdf';
    public const FILE_TYPE_RTF = 'rtf';
    public const FILE_TYPE_DOC = 'doc';
    public const FILE_TYPE_XLS = 'xls';
    public const FILE_TYPE_TXT = 'txt';
    public const FILE_TYPE_HTML = 'html(1)';
    public const FILE_TYPE_ZIP = 'zip';
    public const FILE_TYPE_UNKNOWN = 'onbepaald';

    public const MEDIA_TYPE_PHOTO = 'photo';
    public const MEDIA_TYPE_VIDEO = 'video';
    public const MEDIA_TYPE_WEBRESOURCE = 'webresource';
    public const MEDIA_TYPE_WEBSITE = 'website';
    public const MEDIA_TYPE_CULTUREFEED_PAGE = 'culturefeed-page';
    public const MEDIA_TYPE_RESERVATIONS = 'reservations';
    public const MEDIA_TYPE_ROADMAP = 'roadmap';
    public const MEDIA_TYPE_TEXT = 'text';
    public const MEDIA_TYPE_IMAGEWEB = 'imageweb';
    public const MEDIA_TYPE_IMAGEPRINT = 'imageprint';
    public const MEDIA_TYPE_BLOG = 'blog';
    public const MEDIA_TYPE_YOUTUBE = 'youtube';
    public const MEDIA_TYPE_GOOGLEPLUS = 'google-plus';
    public const MEDIA_TYPE_TWITTER = 'twitter';
    public const MEDIA_TYPE_FACEBOOK = 'facebook';
    public const MEDIA_TYPE_TAGLINE = 'tagline';
    public const MEDIA_TYPE_COLLABORATION = 'collaboration';

    public const REL_TYPE_ORGANISER = 'organiser';

    private bool $main = false;
    private ?string $cdbid = null;
    private ?string $creationDate = null;
    private ?string $channel = null;
    private bool $private = false;
    private string $mediaType;
    private string $title;
    private string $copyright;
    private ?string $fileName = null;
    private ?string $fileType = null;
    private ?string $relationType = null;
    private string $hLink;
    private ?string $plainText = null;
    private ?string $subBrand = null;
    private ?string $description = null;

    public function isMain(): bool
    {
        return $this->main;
    }

    public function isPrivate(): bool
    {
        return $this->private;
    }

    public function getCdbid(): ?string
    {
        return $this->cdbid;
    }

    public function getCreationDate(): ?string
    {
        return $this->creationDate;
    }

    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    public function getChannel(): ?string
    {
        return $this->channel;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCopyright(): string
    {
        return $this->copyright;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function getFileType(): ?string
    {
        return $this->fileType;
    }

    public function getRelationType(): ?string
    {
        return $this->relationType;
    }

    public function getHLink(): string
    {
        return $this->hLink;
    }

    public function getPlainText(): ?string
    {
        return $this->plainText;
    }

    public function getSubBrand(): ?string
    {
        return $this->subBrand;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setMain(bool $main = true): void
    {
        $this->main = $main;
    }

    public function setPrivate(bool $private): void
    {
        $this->private = $private;
    }

    public function setCdbid(string $cdbid): void
    {
        $this->cdbid = $cdbid;
    }

    public function setMediaType(string $type): void
    {
        $this->mediaType = $type;
    }

    public function setChannel(string $channel): void
    {
        $this->channel = $channel;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setCopyright(string $copyright): void
    {
        $this->copyright = $copyright;
    }

    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    public function setFileType(string $fileType): void
    {
        $this->fileType = $fileType;
    }

    public function setRelationType(string $relationType): void
    {
        $this->relationType = $relationType;
    }

    public function setHLink(string $link): void
    {
        $this->hLink = $link;
    }

    public function setPlainText(string $text): void
    {
        $this->plainText = $text;
    }

    public function setSubBrand(string $subBrand): void
    {
        $this->subBrand = $subBrand;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function appendToDOM(DOMElement $element): void
    {
        $dom = $element->ownerDocument;

        $fileElement = $dom->createElement('file');

        if (!empty($this->cdbid)) {
            $fileElement->setAttribute('cdbid', $this->cdbid);
        }

        if (!empty($this->channel)) {
            $fileElement->setAttribute('channel', $this->channel);
        }

        if (!empty($this->creationDate)) {
            $fileElement->setAttribute('creationdate', $this->creationDate);
        }

        if ($this->main) {
            $fileElement->setAttribute('main', 'true');
        }

        if ($this->private) {
            $fileElement->setAttribute('private', 'true');
        }

        if (!empty($this->copyright)) {
            $copyrightElement = $dom->createElement('copyright');
            $copyrightElement->appendChild(
                $dom->createTextNode($this->copyright)
            );
            $fileElement->appendChild($copyrightElement);
        }

        if (!empty($this->description)) {
            $description_element = $dom->createElement('description');
            $description_element->appendChild(
                $dom->createTextNode($this->description)
            );
            $fileElement->appendChild($description_element);
        }

        if (!empty($this->fileName)) {
            $fileNameElement = $dom->createElement('filename');
            $fileNameElement->appendChild(
                $dom->createTextNode($this->fileName)
            );
            $fileElement->appendChild($fileNameElement);
        }

        if (!empty($this->fileType)) {
            $fileElement->appendChild(
                $dom->createElement('filetype', $this->fileType)
            );
        }

        if (!empty($this->hLink)) {
            $hLinkElement = $dom->createElement('hlink');
            $hLinkElement->appendChild($dom->createTextNode($this->hLink));
            $fileElement->appendChild($hLinkElement);
        } elseif (!empty($this->plainText)) {
            $plainTextElement = $dom->createElement('plaintext');
            $plainTextElement->appendChild(
                $dom->createTextNode($this->plainText)
            );
            $fileElement->appendChild($plainTextElement);
        }

        if (!empty($this->mediaType)) {
            $fileElement->appendChild(
                $dom->createElement('mediatype', $this->mediaType)
            );
        }

        if (!empty($this->title)) {
            $titleElement = $dom->createElement('title');
            $titleElement->appendChild($dom->createTextNode($this->title));
            $fileElement->appendChild($titleElement);
        }

        if (!empty($this->relationType)) {
            $fileElement->appendChild(
                $dom->createElement('reltype', $this->relationType)
            );
        }

        if (!empty($this->subBrand)) {
            $sub_brand_element = $dom->createElement('subbrand');
            $sub_brand_element->appendChild(
                $dom->createTextNode($this->subBrand)
            );
            $fileElement->appendChild($sub_brand_element);
        }

        $element->appendChild($fileElement);
    }

    public static function parseFromCdbXml(SimpleXMLElement $xmlElement): CultureFeed_Cdb_Data_File
    {
        $file = new self();

        $attributes = $xmlElement->attributes();
        if (isset($attributes['main'])) {
            $file->main = $attributes['main'] == 'true';
        }

        if (isset($attributes['cdbid'])) {
            $file->cdbid = (string) $attributes['cdbid'];
        }

        if (isset($attributes['creationdate'])) {
            $file->creationDate = (string) $attributes['creationdate'];
        }

        if (isset($attributes['channel'])) {
            $file->channel = (string) $attributes['channel'];
        }

        if (isset($attributes['private'])) {
            $file->private = $attributes['private'] == 'true';
        }

        if (!empty($xmlElement->copyright)) {
            $file->copyright = (string) $xmlElement->copyright;
        }

        if (!empty($xmlElement->filename)) {
            $file->fileName = (string) $xmlElement->filename;
        }

        if (!empty($xmlElement->filetype)) {
            $file->fileType = (string) $xmlElement->filetype;
        }

        if (!empty($xmlElement->reltype)) {
            $file->relationType = (string) $xmlElement->reltype;
        }

        if (!empty($xmlElement->hlink)) {
            $file->hLink = (string) $xmlElement->hlink;
        }

        if (!empty($xmlElement->plaintext)) {
            $file->plainText = (string) $xmlElement->plaintext;
        }

        if (!empty($xmlElement->mediatype)) {
            $file->mediaType = (string) $xmlElement->mediatype;
        }

        if (!empty($xmlElement->title)) {
            $file->title = (string) $xmlElement->title;
        }

        if (!empty($xmlElement->subbrand)) {
            $file->subBrand = trim((string) $xmlElement->subbrand);
        }

        if (!empty($xmlElement->description)) {
            $file->description = trim((string) $xmlElement->description);
        }

        return $file;
    }
}
