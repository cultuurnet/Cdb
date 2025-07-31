<?php

use PHPUnit\Framework\TestCase;

class CultureFeed_Cdb_Item_EventTest extends TestCase
{
    /**
     * @var CultureFeed_Cdb_Item_Event
     */
    protected $event;

    public function setUp(): void
    {
        $this->event = new CultureFeed_Cdb_Item_Event();
    }

    /**
     * @param $fileName
     * @param $cdbScheme
     *
     * @return SimpleXMLElement
     */
    public function loadSample($fileName, $cdbScheme = '3.2')
    {
        $sampleDir = __DIR__ . '/samples/EventTest/cdbxml-' . $cdbScheme . '/';
        $filePath = $sampleDir . $fileName;

        $xml = simplexml_load_file(
            $filePath,
            'SimpleXMLElement',
            0,
            'http://www.cultuurdatabank.com/XMLSchema/CdbXSD/' . $cdbScheme . '/FINAL'
        );

        return $xml;
    }

    /**
     * @param $fileName
     * @param $cdbScheme
     *
     * @return string
     */
    public function samplePath($fileName, $cdbScheme = '3.2')
    {
        $sampleDir = __DIR__ . '/samples/EventTest/cdbxml-' . $cdbScheme . '/';
        $filePath = $sampleDir . $fileName;

        return $filePath;
    }

    public function testAppendsCdbidAttributeOnlyWhenCdbidIsSet()
    {
        $this->assertEquals(null, $this->event->getCdbId());

        $dom = new DOMDocument();
        $eventsElement = $dom->createElement('events');
        $dom->appendChild($eventsElement);
        $this->event->appendToDOM($eventsElement);

        $xpath = new DOMXPath($dom);

        $items = $xpath->query('/events/event');
        $this->assertEquals(1, $items->length);

        $items = $xpath->query('/events/event/@cdbid');
        $this->assertEquals(0, $items->length);

        $uuid = '0FA6D598-F126-4B4F-BCE3-BAF3BD959A35';
        $this->event->setCdbId($uuid);
        $this->assertEquals($uuid, $this->event->getCdbId());

        $dom = new DOMDocument();
        $eventsElement = $dom->createElement('events');
        $dom->appendChild($eventsElement);
        $this->event->appendToDOM($eventsElement);

        $xpath = new DOMXPath($dom);

        $items = $xpath->query('/events/event');
        $this->assertEquals(1, $items->length);

        $items = $xpath->query('/events/event/@cdbid');
        $this->assertEquals(1, $items->length);

        $this->assertEquals($uuid, $items->item(0)->textContent);
    }

    /**
     * @return array
     */
    public function privatePropertyValues()
    {
        return array(
            array(true),
            array(false),
        );
    }

    /**
     * @dataProvider privatePropertyValues
     */
    public function testAppendsBooleanPrivateProperty($value)
    {
        $this->assertNULL($this->event->isPrivate());

        $dom = new DOMDocument();
        $eventsElement = $dom->createElement('events');
        $dom->appendChild($eventsElement);
        $this->event->appendToDOM($eventsElement);

        $xpath = new DOMXPath($dom);

        $items = $xpath->query('/events/event');
        $this->assertEquals(1, $items->length);

        $items = $xpath->query('/events/event/@private');
        $this->assertEquals(0, $items->length);

        $this->event->setPrivate($value);

        $this->assertIsBool($this->event->isPrivate());
        $this->assertEquals($value, $this->event->isPrivate());
    }

    public function privatePropertySamples()
    {
        return array(
            array('private.xml', true),
            array('non-private.xml', false),
        );
    }

    /**
     * @dataProvider privatePropertySamples
     *
     * @param $sampleName
     * @param $value
     */
    public function testCreateFromXmlParsesPrivateAttribute($sampleName, $value)
    {
        $xml = $this->loadSample($sampleName);
        //var_dump($xml->asXML());
        $event = CultureFeed_Cdb_Item_Event::parseFromCdbXml($xml);

        $this->assertEquals($value, $event->isPrivate());
    }

    public function testParseCdbXMLGuideExample6Dot2()
    {
        $xml = $this->loadSample('cdbxml-guide-example-6-2.xml');

        $event = CultureFeed_Cdb_Item_Event::parseFromCdbXml($xml);

        $this->assertInstanceOf('CultureFeed_Cdb_Item_Event', $event);

        $this->assertSame(
            'ea37cae2-c91e-4810-89ab-e060432d2b78',
            $event->getCdbId()
        );
        $this->assertSame('2010-02-25T00:00:00', $event->getAvailableFrom());
        $this->assertSame('2010-08-09T00:00:00', $event->getAvailableTo());
        $this->assertSame('mverdoodt', $event->getCreatedBy());
        $this->assertSame('2010-07-05T18:28:18', $event->getCreationDate());
        $this->assertSame(
            'SKB Import:SKB00001_216413',
            $event->getExternalId()
        );
        $this->assertFalse($event->isParent());
        $this->assertSame('2010-07-28T13:58:55', $event->getLastUpdated());
        $this->assertSame('mverdoodt', $event->getLastUpdatedBy());
        $this->assertSame('SKB Import', $event->getOwner());
        $this->assertIsFloat($event->getPctComplete());
        $this->assertEquals(80, $event->getPctComplete());
        $this->assertFalse($event->isPrivate());
        $this->assertTrue($event->isPublished());
        $this->assertSame('SKB', $event->getValidator());
        $this->assertSame('approved', $event->getWfStatus());

        $this->assertEquals(18, $event->getAgeFrom());

        $calendar = $event->getCalendar();

        $this->assertInstanceOf('CultureFeed_Cdb_Data_Calendar', $calendar);

        $this->assertCount(1, $calendar);

        $calendar->rewind();
        /** @var CultureFeed_Cdb_Data_Calendar_Timestamp $timestamp */
        $timestamp = $calendar->current();

        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_Calendar_Timestamp',
            $timestamp
        );

        $this->assertEquals('2010-08-01', $timestamp->getDate());

        $this->assertEquals('21:00:00.0000000', $timestamp->getStartTime());

        $this->assertNULL($timestamp->getEndTime());

        $categories = $event->getCategories();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_CategoryList',
            $categories
        );

        $this->assertCount(3, $categories);
        $this->assertContainsOnly('CultureFeed_Cdb_Data_Category', $categories);

        $categories->rewind();
        /** @var CultureFeed_Cdb_Data_Category $category */
        $category = $categories->current();
        $this->assertEquals('0.50.4.0.0', $category->getId());
        $this->assertEquals('Concert', $category->getName());
        $this->assertEquals('eventtype', $category->getType());

        $categories->next();
        $category = $categories->current();
        $this->assertEquals('1.8.2.0.0', $category->getId());
        $this->assertEquals('Jazz en blues', $category->getName());
        $this->assertEquals('theme', $category->getType());

        $categories->next();
        $category = $categories->current();
        $this->assertEquals('6.2.0.0.0', $category->getId());
        $this->assertEquals('Regionaal', $category->getName());
        $this->assertEquals('publicscope', $category->getType());

        $contact_info = $event->getContactInfo();
        $mails = $contact_info->getMails();
        $this->assertIsArray($mails);
        $this->assertCount(1, $mails);
        $this->assertContainsOnly('CultureFeed_Cdb_Data_Mail', $mails);

        /** @var CultureFeed_Cdb_Data_Mail $mail */
        $mail = reset($mails);
        $this->assertEquals('info@bonnefooi.be', $mail->getMailAddress());
        $this->assertFalse($mail->isForReservations());
        $this->assertFalse($mail->isMainMail());

        $phones = $contact_info->getPhones();
        $this->assertIsArray($phones);
        $this->assertCount(1, $phones);
        $this->assertContainsOnly('CultureFeed_Cdb_Data_Phone', $phones);

        /** @var CultureFeed_Cdb_Data_Phone $phone */
        $phone = reset($phones);
        $this->assertEquals('0487-62.22.31', $phone->getNumber());
        $this->assertFalse($phone->isForReservations());
        $this->assertFalse($phone->isMainPhone());
        $this->assertNULL($phone->getType());

        $urls = $contact_info->getUrls();
        $this->assertIsArray($urls);
        $this->assertCount(1, $urls);
        $this->assertContainsOnly('CultureFeed_Cdb_Data_Url', $urls);

        /** @var CultureFeed_Cdb_Data_Url $url */
        $url = reset($urls);
        $this->assertEquals('http://www.bonnefooi.be', $url->getUrl());
        $this->assertTrue($url->isMain());
        $this->assertFalse($url->isForReservations());

        $event_detail_list = $event->getDetails();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_DetailList',
            $event_detail_list
        );
        $this->assertCount(2, $event_detail_list);
        $this->assertContainsOnly(
            'CultureFeed_Cdb_Data_EventDetail',
            $event_detail_list
        );

        $event_detail_list->rewind();
        /** @var CultureFeed_Cdb_Data_EventDetail $detail */
        $detail = $event_detail_list->current();
        $this->assertEquals('nl', $detail->getLanguage());

        $this->assertEquals(
            'zo 01/08/10 om 21:00',
            $detail->getCalendarSummary()
        );

        $performers = $detail->getPerformers();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_PerformerList',
            $performers
        );
        $this->assertCount(1, $performers);
        $this->assertContainsOnly(
            'CultureFeed_Cdb_Data_Performer',
            $performers
        );

        $performers->rewind();
        /** @var CultureFeed_Cdb_Data_Performer $performer */
        $performer = $performers->current();

        $this->assertEquals('Muzikant', $performer->getRole());
        $this->assertEquals(
            'Matt, the Englishman in Brussels',
            $performer->getLabel()
        );

        $this->assertEquals(
            'Weggelaten voor leesbaarheid...',
            $detail->getLongDescription()
        );

        $media = $detail->getMedia();
        $this->assertInstanceOf('CultureFeed_Cdb_Data_Media', $media);
        $this->assertCount(1, $media);

        $media->rewind();
        /** @var CultureFeed_Cdb_Data_File $media_item */
        $media_item = $media->current();
        $this->assertInstanceOf('CultureFeed_Cdb_Data_File', $media_item);
        $this->assertEquals('Bonnefooi', $media_item->getCopyright());
        $this->assertEquals(
            'http://www.bonnefooi.be/images/sized/site/images/uploads/Jeroen_Jamming-453x604.jpg',
            $media_item->getHLink()
        );
        $this->assertEquals('imageweb', $media_item->getMediaType());
        $this->assertEquals('Jeroen Jamming', $media_item->getTitle());
        $this->assertNull($media_item->getCdbid());
        $this->assertNull($media_item->getChannel());
        $this->assertNull($media_item->getCreationDate());
        $this->assertNull($media_item->getFileName());
        $this->assertNull($media_item->getFileType());
        $this->assertNull($media_item->getPlainText());
        $this->assertNull($media_item->getRelationType());

        $this->assertEquals('The Bonnefooi Acoustic Jam', $detail->getTitle());

        $price = $detail->getPrice();
        $this->assertInstanceOf('CultureFeed_Cdb_Data_Price', $price);
        $this->assertNull($price->getDescription());
        $this->assertEquals('The Bonnefooi Acoustic Jam', $price->getTitle());
        $this->assertEquals(0, $price->getValue());

        $event_detail_list->next();
        $detail = $event_detail_list->current();

        $this->assertEquals('en', $detail->getLanguage());

        // @todo According to the code in Cdb_Data_CultureFeed_Cdb_Item_Event,
        // keywords are delimited by a semicolon, in our xml sample however they seem to be delimited
        // by a comma.
        $keywords = $event->getKeywords();
        $this->assertIsArray($keywords);
        $this->assertCount(1, $keywords);
        $this->assertContainsOnly('string', $keywords, true);

        $keyword = reset($keywords);
        $this->assertEquals('Free Jazz, Acoustisch', $keyword);

        $languages = $event->getLanguages();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_LanguageList',
            $languages
        );
        $this->assertCount(2, $languages);
        $languages->rewind();
        /** @var CultureFeed_Cdb_Data_Language $language */
        $language = $languages->current();
        $this->assertEquals('spoken', $language->getType());
        $this->assertEquals('Nederlands', $language->getLanguage());

        $languages->next();
        $language = $languages->current();
        $this->assertEquals('spoken', $language->getType());
        $this->assertEquals('Frans', $language->getLanguage());

        $location = $event->getLocation();
        $this->assertInstanceOf('CultureFeed_Cdb_Data_Location', $location);
        $this->assertNull($location->getActor());
        $this->assertEquals(
            '920e9755-94a0-42c1-8c8c-9d17f693d0be',
            $location->getCdbid()
        );
        $this->assertEquals('Café Bonnefooi', $location->getLabel());

        $address = $location->getAddress();
        $this->assertInstanceOf('CultureFeed_Cdb_Data_Address', $address);
        $this->assertNull($address->getLabel());
        $physical_address = $address->getPhysicalAddress();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_Address_PhysicalAddress',
            $physical_address
        );
        $this->assertEquals('Brussel', $physical_address->getCity());
        $this->assertEquals('BE', $physical_address->getCountry());
        $this->assertNull($physical_address->getGeoInformation());
        $this->assertEquals('8', $physical_address->getHouseNumber());
        $this->assertEquals('Steenstraat', $physical_address->getStreet());
        $this->assertEquals('1000', $physical_address->getZip());

        $this->assertNull($address->getVirtualAddress());

        $organiser = $event->getOrganiser();
        $this->assertInstanceOf('CultureFeed_Cdb_Data_Organiser', $organiser);

        $this->assertEquals('Café Bonnefooi', $organiser->getLabel());
    }

    public function testParseEvent20140108()
    {
        $xml = $this->loadSample('test-event-2014-01-08.xml');

        $event = CultureFeed_Cdb_Item_Event::parseFromCdbXml($xml);

        $this->assertEquals(
            'd53c2bc9-8f0e-4c9a-8457-77e8b3cab3d1',
            $event->getCdbId()
        );
        $this->assertEquals('2014-01-08T00:00:00', $event->getAvailableFrom());
        $this->assertEquals('2014-02-21T00:00:00', $event->getAvailableTo());
        $this->assertEquals('jonas@cultuurnet.be', $event->getCreatedBy());
        $this->assertEquals('2014-01-08T09:43:52', $event->getCreationDate());
        $this->assertEquals(
            'CDB:c2156058-9393-4c95-8821-7787170527c0',
            $event->getExternalId()
        );
        $this->assertEquals('2014-01-08T09:46:41', $event->getLastUpdated());
        $this->assertEquals('jonas@cultuurnet.be', $event->getLastUpdatedBy());
        $this->assertEquals('CultuurNet Validatoren', $event->getOwner());
        $this->assertEquals(95, $event->getPctComplete());
        $this->assertFalse($event->isPrivate());
        $this->assertTrue($event->isPublished());
        $this->assertEquals('UiTdatabank Validatoren', $event->getValidator());
        $this->assertEquals('approved', $event->getWfStatus());
        $this->assertFalse($event->isParent());

        $this->assertEquals(5, $event->getAgeFrom());

        $calendar = $event->getCalendar();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_Calendar_TimestampList',
            $calendar
        );
        $this->assertCount(2, $calendar);
        $this->assertContainsOnly(
            'CultureFeed_Cdb_Data_Calendar_Timestamp',
            $calendar
        );

        $calendar->rewind();
        /** @var CultureFeed_Cdb_Data_Calendar_Timestamp $timestamp */
        $timestamp = $calendar->current();

        $this->assertEquals('2014-01-31', $timestamp->getDate());
        $this->assertEquals('12:00:00', $timestamp->getStartTime());
        $this->assertEquals('15:00:00', $timestamp->getEndTime());

        $calendar->next();
        $timestamp = $calendar->current();

        $this->assertEquals('2014-02-20', $timestamp->getDate());
        $this->assertEquals('12:00:00', $timestamp->getStartTime());
        $this->assertEquals('15:00:00', $timestamp->getEndTime());

        $categories = $event->getCategories();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_CategoryList',
            $categories
        );
        $this->assertCount(6, $categories);

        $categories->rewind();
        /** @var CultureFeed_Cdb_Data_Category $category */
        $category = $categories->current();

        $this->assertEquals('1.7.6.0.0', $category->getId());
        $this->assertEquals('Griezelfilm of horror', $category->getName());
        $this->assertEquals('theme', $category->getType());

        $categories->next();
        $category = $categories->current();
        $this->assertEquals('6.0.0.0.0', $category->getId());
        $this->assertEquals('Wijk of buurt', $category->getName());
        $this->assertEquals('publicscope', $category->getType());

        $categories->next();
        $category = $categories->current();
        $this->assertEquals('2.2.1.0.0', $category->getId());
        $this->assertEquals('Vanaf kleuterleeftijd (3+)', $category->getName());
        $this->assertEquals('targetaudience', $category->getType());

        $categories->next();
        $category = $categories->current();
        $this->assertEquals('0.50.6.0.0', $category->getId());
        $this->assertEquals('Film', $category->getName());
        $this->assertEquals('eventtype', $category->getType());

        $categories->next();
        $category = $categories->current();
        $this->assertEquals('reg.1565', $category->getId());
        $this->assertEquals('1000 Brussel', $category->getName());
        $this->assertEquals('flandersregion', $category->getType());

        $categories->next();
        $category = $categories->current();
        $this->assertEquals('umv.7', $category->getId());
        $this->assertEquals('Film', $category->getName());
        $this->assertEquals('umv', $category->getType());

        $contact_info = $event->getContactInfo();

        $addresses = $contact_info->getAddresses();
        $this->assertIsArray($addresses);
        $this->assertCount(1, $addresses);

        /** @var CultureFeed_Cdb_Data_Address $address */
        $address = reset($addresses);
        $this->assertInstanceOf('CultureFeed_Cdb_Data_Address', $address);
        $physicalAddress = $address->getPhysicalAddress();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_Address_PhysicalAddress',
            $physicalAddress
        );
        $this->assertEquals('Brussel', $physicalAddress->getCity());
        $this->assertEquals('BE', $physicalAddress->getCountry());
        $gis = $physicalAddress->getGeoInformation();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_Address_GeoInformation',
            $gis
        );
        $this->assertEquals(4.350000, $gis->getXCoordinate());
        $this->assertEquals(50.850000, $gis->getYCoordinate());
        $this->assertEquals(
            'Sint-Gislainstraat',
            $physicalAddress->getStreet()
        );
        $this->assertEquals('62', $physicalAddress->getHouseNumber());
        $phones = $contact_info->getPhones();
        $this->assertIsArray($phones);
        $this->assertCount(1, $phones);
        $this->assertContainsOnly('CultureFeed_Cdb_Data_Phone', $phones);
        /** @var CultureFeed_Cdb_Data_Phone $phone */
        $phone = reset($phones);
        $this->assertEquals('123', $phone->getNumber());
        $this->assertEquals('phone', $phone->getType());

        $urls = $contact_info->getUrls();
        $this->assertIsArray($urls);
        $this->assertCount(1, $urls);
        $this->assertContainsOnly('CultureFeed_Cdb_Data_Url', $urls);

        /** @var CultureFeed_Cdb_Data_Url $url */
        $url = reset($urls);

        $this->assertEquals('http://www.test.com', $url->getUrl());

        $details = $event->getDetails();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_EventDetailList',
            $details
        );
        $this->assertCount(3, $details);
        $this->assertContainsOnly('CultureFeed_Cdb_Data_EventDetail', $details);

        $details->rewind();
        /** @var CultureFeed_Cdb_Data_EventDetail $detail */
        $detail = $details->current();
        $this->assertEquals('nl', $detail->getLanguage());
        $this->assertEquals(
            'vrij 31/01/14 van 12:00 tot 15:00 do 20/02/14 van 12:00 tot 15:00',
            $detail->getCalendarSummary()
        );

        $performers = $detail->getPerformers();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_PerformerList',
            $performers
        );
        $this->assertCount(2, $performers);
        $this->assertContainsOnly(
            'CultureFeed_Cdb_Data_Performer',
            $performers
        );

        $performers->rewind();
        /** @var CultureFeed_Cdb_Data_Performer $performer */
        $performer = $performers->current();
        $this->assertEquals('Muzikant', $performer->getRole());
        $this->assertEquals('Tim Vanhamel', $performer->getLabel());

        $performers->next();
        $performer = $performers->current();
        $this->assertEquals('Director', $performer->getRole());
        $this->assertEquals('Jon Dedonder', $performer->getLabel());

        $media = $detail->getMedia();
        $this->assertInstanceOf('CultureFeed_Cdb_Data_Media', $media);
        $this->assertCount(2, $media);
        $this->assertContainsOnly('CultureFeed_Cdb_Data_File', $media);

        $media->rewind();
        /** @var CultureFeed_Cdb_Data_File $file */
        $file = $media->current();
        $this->assertTrue($file->isMain());
        $this->assertEquals('webresource', $file->getMediaType());
        $this->assertEquals('http://www.test.com', $file->getHLink());

        $media->next();
        $file = $media->current();
        $this->assertFalse($file->isMain());
        $this->assertEquals('8/01/2014 9:44:59', $file->getCreationDate());
        $this->assertEquals('Zelf gemaakt', $file->getCopyright());
        $this->assertEquals(
            '9554d6f6-bed1-4303-8d42-3fcec4601e0e.jpg',
            $file->getFileName()
        );
        $this->assertEquals(
            'http://85.255.197.172/images/20140108/9554d6f6-bed1-4303-8d42-3fcec4601e0e.jpg',
            $file->getHLink()
        );
        $this->assertEquals('jpeg', $file->getFileType());
        $this->assertEquals('photo', $file->getMediaType());

        $price = $detail->getPrice();
        $this->assertInstanceOf('CultureFeed_Cdb_Data_Price', $price);
        $this->assertEquals(4.00, $price->getValue());
        $this->assertEquals(
            'Extra Korting voor vroegboekers',
            $price->getDescription()
        );

        $this->assertEquals('KB', $detail->getShortDescription());
        $this->assertEquals('Ruime Activiteit', $detail->getTitle());

        $details->next();
        $detail = $details->current();
        $this->assertEquals('fr', $detail->getLanguage());
        $this->assertEquals(
            'ven 31/01/14 de 12:00 à 15:00 jeu 20/02/14 de 12:00 à 15:00',
            $detail->getCalendarSummary()
        );
        $this->assertNULL($detail->getShortDescription());
        $this->assertEquals('RB', $detail->getTitle());

        $details->next();
        $detail = $details->current();
        $this->assertEquals('de', $detail->getLanguage());
        $this->assertEquals(
            'Fr 31/01/14 von 12:00 bis zum 15:00 Do 20/02/14 von 12:00 bis zum 15:00',
            $detail->getCalendarSummary()
        );
        $this->assertEquals('KB', $detail->getShortDescription());
        $this->assertEquals('RB', $detail->getTitle());

        $keywords = $event->getKeywords();
        $this->assertIsArray($keywords);
        $this->assertCount(2, $keywords);

        $keyword = reset($keywords);
        $this->assertEquals('feest', $keyword);

        $keyword = next($keywords);
        $this->assertEquals('test', $keyword);

        $location = $event->getLocation();
        $this->assertInstanceOf('CultureFeed_Cdb_Data_Location', $location);
        $address = $location->getAddress();
        $this->assertInstanceOf('CultureFeed_Cdb_Data_Address', $address);
        $physical_address = $address->getPhysicalAddress();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_Address_PhysicalAddress',
            $physical_address
        );

        $this->assertEquals('Brussel', $physical_address->getCity());
        $this->assertEquals('BE', $physical_address->getCountry());
        $gis = $physicalAddress->getGeoInformation();
        $this->assertInstanceOf(
            'CultureFeed_Cdb_Data_Address_GeoInformation',
            $gis
        );
        $this->assertEquals(4.350000, $gis->getXCoordinate());
        $this->assertEquals(50.850000, $gis->getYCoordinate());
        $this->assertEquals('62', $physical_address->getHouseNumber());
        $this->assertEquals(
            'Sint-Gislainstraat',
            $physical_address->getStreet()
        );
        $this->assertEquals('1000', $physical_address->getZip());

        $this->assertEquals(
            '47B6FA21-ACB1-EA8F-2C231182C7DD0A19',
            $location->getCdbid()
        );
        $this->assertEquals('CultuurNet Vlaanderen', $location->getLabel());

        $organiser = $event->getOrganiser();
        $this->assertInstanceOf('CultureFeed_Cdb_Data_Organiser', $organiser);
        $this->assertEquals('CultuurNet Vlaanderen', $organiser->getLabel());
        $this->assertEquals(
            '47B6FA21-ACB1-EA8F-2C231182C7DD0A19',
            $organiser->getCdbid()
        );
    }

    public function testCreateCdbXMLGuideExample6Dot2()
    {
        $event = new CultureFeed_Cdb_Item_Event();
        $event->setAvailableFrom('2010-02-25T00:00:00');
        $event->setAvailableTo('2010-08-09T00:00:00');
        $event->setCdbId('ea37cae2-c91e-4810-89ab-e060432d2b78');
        $event->setCreatedBy('mverdoodt');
        $event->setCreationDate('2010-07-05T18:28:18');
        $event->setExternalId('SKB Import:SKB00001_216413');
        $event->setIsParent(false);
        $event->setLastUpdated('2010-07-28T13:58:55');
        $event->setLastUpdatedBy('mverdoodt');
        $event->setOwner('SKB Import');
        $event->setPctComplete(80);
        $event->setPublished(true);
        $event->setValidator('SKB');
        $event->setWfStatus('approved');
        $event->setAgeFrom(18);
        $event->setPrivate(false);

        $calendar = new CultureFeed_Cdb_Data_Calendar_TimestampList();
        $calendar->add(
            new CultureFeed_Cdb_Data_Calendar_Timestamp(
                '2010-08-01',
                '21:00:00.0000000'
            )
        );
        $event->setCalendar($calendar);

        $categories = new CultureFeed_Cdb_Data_CategoryList();
        $categories->add(
            new CultureFeed_Cdb_Data_Category(
                CultureFeed_Cdb_Data_Category::CATEGORY_TYPE_EVENT_TYPE,
                '0.50.4.0.0',
                'Concert'
            )
        );
        $categories->add(
            new CultureFeed_Cdb_Data_Category(
                CultureFeed_Cdb_Data_Category::CATEGORY_TYPE_THEME,
                '1.8.2.0.0',
                'Jazz en blues'
            )
        );
        $categories->add(
            new CultureFeed_Cdb_Data_Category(
                CultureFeed_Cdb_Data_Category::CATEGORY_TYPE_PUBLICSCOPE,
                '6.2.0.0.0',
                'Regionaal'
            )
        );
        $event->setCategories($categories);

        $contactInfo = new CultureFeed_Cdb_Data_ContactInfo();
        $contactInfo->addMail(
            new CultureFeed_Cdb_Data_Mail('info@bonnefooi.be', null, null)
        );
        $contactInfo->addPhone(new CultureFeed_Cdb_Data_Phone('0487-62.22.31'));
        $url = new CultureFeed_Cdb_Data_Url('http://www.bonnefooi.be');
        $url->setMain();
        $contactInfo->addUrl($url);
        $event->setContactInfo($contactInfo);

        $details = new CultureFeed_Cdb_Data_EventDetailList();

        $detailNl = new CultureFeed_Cdb_Data_EventDetail();
        $detailNl->setLanguage('nl');
        $detailNl->setTitle('The Bonnefooi Acoustic Jam');
        $detailNl->setCalendarSummary('zo 01/08/10 om 21:00');

        $performers = new CultureFeed_Cdb_Data_PerformerList();
        $performers->add(
            new CultureFeed_Cdb_Data_Performer(
                'Muzikant',
                'Matt, the Englishman in Brussels'
            )
        );
        $detailNl->setPerformers($performers);

        $detailNl->setLongDescription('Weggelaten voor leesbaarheid...');

        $file = new CultureFeed_Cdb_Data_File();
        $file->setMain();
        $file->setCopyright('Bonnefooi');
        $file->setHLink(
            'http://www.bonnefooi.be/images/sized/site/images/uploads/Jeroen_Jamming-453x604.jpg'
        );
        $file->setMediaType(CultureFeed_Cdb_Data_File::MEDIA_TYPE_IMAGEWEB);
        $file->setTitle('Jeroen Jamming');

        $detailNl->getMedia()->add($file);

        $price = new CultureFeed_Cdb_Data_Price(0);
        $price->setTitle('The Bonnefooi Acoustic Jam');
        $detailNl->setPrice($price);

        $detailNl->setShortDescription('Korte omschrijving.');

        $details->add($detailNl);

        $detailEn = new CultureFeed_Cdb_Data_EventDetail();
        $detailEn->setLanguage('en');
        $detailEn->setShortDescription('Short description.');
        $details->add($detailEn);

        $event->setDetails($details);

        // @todo Add headings.
        //$headings = array();

        $event->addKeyword('Free Jazz, Acoustisch');

        $address = new CultureFeed_Cdb_Data_Address();
        $physicalAddress = new CultureFeed_Cdb_Data_Address_PhysicalAddress();
        $physicalAddress->setCity('Brussel');
        $physicalAddress->setCountry('BE');
        $physicalAddress->setHouseNumber(8);
        $physicalAddress->setStreet('Steenstraat');
        $physicalAddress->setZip(1000);
        $address->setPhysicalAddress($physicalAddress);

        $location = new CultureFeed_Cdb_Data_Location($address);

        $location->setLabel('Café Bonnefooi');
        $location->setCdbid('920e9755-94a0-42c1-8c8c-9d17f693d0be');
        $event->setLocation($location);

        $organiser = new CultureFeed_Cdb_Data_Organiser();
        $organiser->setLabel('Café Bonnefooi');
        $event->setOrganiser($organiser);

        $languages = new CultureFeed_Cdb_Data_LanguageList();
        $languages->add(
            new CultureFeed_Cdb_Data_Language(
                'Nederlands',
                CultureFeed_Cdb_Data_Language::TYPE_SPOKEN
            )
        );
        $languages->add(
            new CultureFeed_Cdb_Data_Language(
                'Frans',
                CultureFeed_Cdb_Data_Language::TYPE_SPOKEN
            )
        );
        $event->setLanguages($languages);

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dummy_element = $dom->createElementNS(
            CultureFeed_Cdb_Xml::namespaceUri(),
            'cdbxml'
        );

        $dom->appendChild($dummy_element);

        $event->appendToDOM($dummy_element);

        $xpath = new DOMXPath($dom);

        $items = $xpath->query('//event');
        $this->assertEquals(1, $items->length);

        $event_element = $items->item(0);

        $dom->removeChild($dummy_element);
        $dom->appendChild($event_element);
        /*$namespaceAttribute = $dom->createAttribute('xmlns');
        $namespaceAttribute->value = CultureFeed_Cdb_Xml::namespaceUri();
        $event_element->appendChild($namespaceAttribute);*/

        // @todo Put xmlns attribute first.

        $xml = $dom->saveXML();

        $sample_dom = new DOMDocument('1.0', 'UTF-8');
        $contents = file_get_contents(
            $this->samplePath('cdbxml-guide-example-6-2.xml')
        );
        $contents = str_replace(
            'xmlns="http://www.cultuurdatabank.com/XMLSchema/CdbXSD/3.2/FINAL" ',
            '',
            $contents
        );
        $sample_dom->preserveWhiteSpace = false;
        $sample_dom->formatOutput = true;
        $sample_dom->loadXML($contents);
        $sample_dom->preserveWhiteSpace = false;
        $sample_dom->formatOutput = true;

        $expected_xml = $sample_dom->saveXML();
        //$this->assertEquals($sample_dom->documentElement->C14N(), $dom->documentElement->C14N());
        $this->assertEquals($expected_xml, $xml);
    }

    public function testCreateTestEvent20140108()
    {
        $event = new CultureFeed_Cdb_Item_Event();
        $event->setAvailableFrom('2014-01-08T00:00:00');
        $event->setAvailableTo('2014-02-21T00:00:00');
        $event->setCdbId('d53c2bc9-8f0e-4c9a-8457-77e8b3cab3d1');
        $event->setCreatedBy('jonas@cultuurnet.be');
        $event->setCreationDate('2014-01-08T09:43:52');
        $event->setExternalId('CDB:c2156058-9393-4c95-8821-7787170527c0');
        $event->setIsParent(false);
        $event->setLastUpdated('2014-01-08T09:46:41');
        $event->setLastUpdatedBy('jonas@cultuurnet.be');
        $event->setOwner('CultuurNet Validatoren');
        $event->setPctComplete(95);
        $event->setPublished();
        $event->setValidator('CultuurNet Validatoren');
        $event->setWfStatus('approved');
        $event->setAgeFrom(5);
        $event->setPrivate(false);

        $calender = new CultureFeed_Cdb_Data_Calendar_TimestampList();
        $calender->add(
            new CultureFeed_Cdb_Data_Calendar_Timestamp(
                '2014-01-31',
                '12:00:00',
                '15:00:00'
            )
        );
        $calender->add(
            new CultureFeed_Cdb_Data_Calendar_Timestamp(
                '2014-02-20',
                '12:00:00',
                '15:00:00'
            )
        );
        $event->setCalendar($calender);

        $categories = new CultureFeed_Cdb_Data_CategoryList();

        $categories->add(
            new CultureFeed_Cdb_Data_Category(
                CultureFeed_Cdb_Data_Category::CATEGORY_TYPE_THEME,
                '1.7.6.0.0',
                'Griezelfilm of horror'
            )
        );

        $categories->add(
            new CultureFeed_Cdb_Data_Category(
                CultureFeed_Cdb_Data_Category::CATEGORY_TYPE_PUBLICSCOPE,
                '6.0.0.0',
                'Wijk of buurt'
            )
        );

        $categories->add(
            new CultureFeed_Cdb_Data_Category(
                CultureFeed_Cdb_Data_Category::CATEGORY_TYPE_TARGET_AUDIENCE,
                '2.2.1.0.0',
                'Vanaf kleuterleeftijd (3+)'
            )
        );

        $categories->add(
            new CultureFeed_Cdb_Data_Category(
                CultureFeed_Cdb_Data_Category::CATEGORY_TYPE_FLANDERS_REGION,
                'reg.1565',
                '1000 Brussel'
            )
        );

        $categories->add(
            new CultureFeed_Cdb_Data_Category(
                'umv',
                'umv.7',
                'Film'
            )
        );

        $contactInfo = new CultureFeed_Cdb_Data_ContactInfo();
        $event->setContactInfo($contactInfo);

        $address = new CultureFeed_Cdb_Data_Address();
        $physicalAddress = new CultureFeed_Cdb_Data_Address_PhysicalAddress();
        $address->setPhysicalAddress($physicalAddress);
        $physicalAddress->setCity('Brussel');
        $physicalAddress->setCountry('BE');
        $geo = new CultureFeed_Cdb_Data_Address_GeoInformation(
            '4.350000',
            '50.850000'
        );
        $physicalAddress->setGeoInformation($geo);
        $physicalAddress->setStreet('Sint-Gislainstraat');
        $physicalAddress->setHouseNumber('62');
        $physicalAddress->setZip(1000);
        $contactInfo->addAddress($address);
        $mail = new CultureFeed_Cdb_Data_Mail('jonas@cnet.be');
        $contactInfo->addMail($mail);
        $phone = new CultureFeed_Cdb_Data_Phone('123');
        $contactInfo->addPhone($phone);
        $url = new CultureFeed_Cdb_Data_Url('http://www.test.com');
        $contactInfo->addUrl($url);

        $details = new CultureFeed_Cdb_Data_EventDetailList();
        $event->setDetails($details);

        $detailNl = new CultureFeed_Cdb_Data_EventDetail();
        $detailNl->setLanguage('nl');
        $detailNl->setCalendarSummary(
            'vrij 31/01/14 van 12:00 tot 15:00 do 20/02/14 van 12:00 tot 15:00'
        );

        $performers = new CultureFeed_Cdb_Data_PerformerList();
        $performers->add(
            new CultureFeed_Cdb_Data_Performer('Muzikant', 'Tim Vanhamel')
        );
        $performers->add(
            new CultureFeed_Cdb_Data_Performer('Director', 'Jon Dedonder')
        );
        $detailNl->setPerformers($performers);
        $details->add($detailNl);

        $media = $detailNl->getMedia();

        $media->rewind();
        $file = new CultureFeed_Cdb_Data_File();
        $file->setHLink('http://www.test.com');
        $file->setMediaType(CultureFeed_Cdb_Data_File::MEDIA_TYPE_IMAGEWEB);
        $file->setMain();
        $media->add($file);

        $file = new CultureFeed_Cdb_Data_File();
        $file->setCopyright('Zelf gemaakt');
        $file->setHLink(
            'http://85.255.197.172/images/20140108/9554d6f6-bed1-4303-8d42-3fcec4601e0e.jpg'
        );
        $file->setMediaType(CultureFeed_Cdb_Data_File::MEDIA_TYPE_PHOTO);
        $file->setFileName('9554d6f6-bed1-4303-8d42-3fcec4601e0e.jpg');

        $media->add($file);

        $price = new CultureFeed_Cdb_Data_Price(4.00);
        $price->setDescription('Extra Korting voor vroegboekers');
        $detailNl->setPrice($price);

        $this->expectNotToPerformAssertions();
    }

    /**
     * Asserts that two XML documents are equal.
     *
     * @param  string $expectedFile
     * @param  string $actualXml
     * @param  string $message
     *
     * @since  Method available since Release 3.3.0
     */
    public static function assertXmlStringEqualsXmlFile(string $expectedFile, $actualXml, string $message = ''): void
    {
        self::assertFileExists($expectedFile);

        $expected = new DOMDocument('1.0', 'utf-8');
        $expected->preserveWhiteSpace = false;
        $expected->load($expectedFile);
        $expected->preserveWhiteSpace = false;
        $expected->formatOutput = false;

        $actual = new DOMDocument('1.0', 'utf-8');
        $actual->preserveWhiteSpace = false;
        $actual->loadXML($actualXml);
        $actual->preserveWhiteSpace = false;
        $actual->formatOutput = false;

        self::assertEquals($expected, $actual, $message);
    }

    public function testGetKeywordsAsObjects()
    {
        $this->event->addKeyword('foo');
        $this->event->addKeyword('bar');

        $this->assertEquals(
            array(
                'foo' => new CultureFeed_Cdb_Data_Keyword('foo'),
                'bar' => new CultureFeed_Cdb_Data_Keyword('bar'),
            ),
            $this->event->getKeywords(true)
        );
    }

    public function testAddKeywordObjects()
    {
        $this->event->addKeyword(new CultureFeed_Cdb_Data_Keyword('foo'));
        $this->event->addKeyword(
            new CultureFeed_Cdb_Data_Keyword('bar', false)
        );

        $this->assertEquals(
            array(
                'foo' => 'foo',
                'bar' => 'bar',
            ),
            $this->event->getKeywords()
        );

        $this->assertEquals(
            array(
                'foo' => new CultureFeed_Cdb_Data_Keyword('foo'),
                'bar' => new CultureFeed_Cdb_Data_Keyword('bar', false),
            ),
            $this->event->getKeywords(true)
        );
    }

    public function testDeleteKeywordObjects()
    {
        $this->event->addKeyword(new CultureFeed_Cdb_Data_Keyword('foo'));
        $this->event->addKeyword(new CultureFeed_Cdb_Data_Keyword('bar'));

        $this->event->deleteKeyword(new CultureFeed_Cdb_Data_Keyword('bar'));

        $this->assertEquals(
            array(
                'foo' => new CultureFeed_Cdb_Data_Keyword('foo'),
            ),
            $this->event->getKeywords(true)
        );
    }

    public function testParseKeywordsXml()
    {

        $xml = $this->loadSample('test-event-2014-01-08.xml', '3.3');
        $event = CultureFeed_Cdb_Item_Event::parseFromCdbXml($xml);

        $this->assertEquals(
            array(
                'feest' => new CultureFeed_Cdb_Data_Keyword('feest'),
                'test' => new CultureFeed_Cdb_Data_Keyword('test', false),
            ),
            $event->getKeywords(true)
        );
    }

    public function testDeleteKeywordWithStringArgument()
    {
        $this->event->addKeyword('foo');
        $this->event->addKeyword(
            new CultureFeed_Cdb_Data_Keyword('bar', false)
        );
        $this->event->addKeyword(
            new CultureFeed_Cdb_Data_Keyword('baz', false)
        );

        $this->event->deleteKeyword('bar');

        $this->assertEquals(
            array(
                'foo' => 'foo',
                'baz' => 'baz',
            ),
            $this->event->getKeywords()
        );

        $this->assertEquals(
            array(
                'foo' => new CultureFeed_Cdb_Data_Keyword('foo'),
                'baz' => new CultureFeed_Cdb_Data_Keyword('baz', false),
            ),
            $this->event->getKeywords(true)
        );
    }

    /**
     * Test keyword appendToDom for cdb < 3.3
     */
    public function testKeywordAppendToDomAsValue()
    {

        $event = new CultureFeed_Cdb_Item_Event();
        $event->addKeyword(new CultureFeed_Cdb_Data_Keyword('foo'));
        $event->addKeyword(new CultureFeed_Cdb_Data_Keyword('bar', false));

        $dom = new DOMDocument('1.0', 'utf-8');
        $eventsElement = $dom->createElement('events');
        $dom->appendChild($eventsElement);
        $event->appendToDOM($eventsElement);

        $xpath = new DOMXPath($dom);

        $items = $xpath->query('/events/event/keywords');
        $xml = $dom->saveXML($items->item(0));

        $this->assertXmlStringEqualsXmlFile(
            __DIR__ . '/samples/EventTest/cdbxml-3.2/keyword_values.xml',
            $xml
        );
    }

    /**
     * Test keyword appendToDom for cdb 3.3
     */
    public function testKeywordAppendToDomAsTag()
    {

        $event = new CultureFeed_Cdb_Item_Event();
        $event->addKeyword(new CultureFeed_Cdb_Data_Keyword('foo'));
        $event->addKeyword(new CultureFeed_Cdb_Data_Keyword('bar', false));

        $dom = new DOMDocument('1.0', 'utf-8');
        $eventsElement = $dom->createElement('events');
        $dom->appendChild($eventsElement);
        $event->appendToDOM($eventsElement, '3.3');

        $xpath = new DOMXPath($dom);

        $items = $xpath->query('/events/event/keywords');

        $xml = $dom->saveXML($items->item(0));
        $this->assertXmlStringEqualsXmlFile(
            __DIR__ . '/samples/EventTest/cdbxml-3.3/keyword_tags.xml',
            $xml
        );
    }

    public function testGetAndSetPublisher()
    {
        $event = new CultureFeed_Cdb_Item_Event();
        $this->assertNull($event->getPublisher());

        $event->setPublisher('xyz');
        $this->assertSame('xyz', $event->getPublisher());
    }

    public function testGetAndSetWeight()
    {
        $event = new CultureFeed_Cdb_Item_Event();
        $this->assertNull($event->getWeight());

        $event->setWeight(1);
        $this->assertSame(1, $event->getWeight());
    }

    /**
     * Integration test for parsing the following additions to cdbxml version
     * 3.3:
     *   - event publisher and weight
     *   - file subbrand and description
     */
    public function testParseCdbXml3Dot3SchemaAdditions()
    {
        $xml = $this->loadSample(
            '085377d6-a3c9-4c8f-88b9-3d6ab0201361.xml',
            '3.3'
        );
        $event = CultureFeed_Cdb_Item_Event::parseFromCdbXml($xml);

        $this->assertEquals(
            '085377d6-a3c9-4c8f-88b9-3d6ab0201361',
            $event->getCdbId()
        );

        $this->assertEquals(
            '48fe254ceba710aec4609017d2e34d91',
            $event->getPublisher()
        );

        $this->assertSame(12, $event->getWeight());

        $nlDetail = $event->getDetails()->getDetailByLanguage('nl');
        $media = $nlDetail->getMedia();
        $media->next();
        /** @var CultureFeed_Cdb_Data_File $secondFile */
        $secondFile = $media->current();

        $this->assertEquals(
            '{"keyword": "Culturefeed.be selectie",
"text": "Hello World",
"image": "https://www.facebook.com/23424317091/photos/a.200759332091.131532.23424317091/10153148846107092/?type=1",
"article": "http://www.humo.be/jeroom/3973/"}',
            $secondFile->getDescription()
        );

        $this->assertEquals(
            '2b88e17a-27fc-4310-9556-4df7188a051f',
            $secondFile->getSubBrand()
        );
    }
}
