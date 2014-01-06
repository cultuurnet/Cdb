<?php

class CultureFeed_Cdb_Item_EventTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CultureFeed_Cdb_Item_Event
     */
    protected $event;

    public function setUp()
    {
        $this->event = new CultureFeed_Cdb_Item_Event();
    }

    /**
     * @param $fileName
     * @return SimpleXMLElement
     */
    public function loadSample($fileName) {
        $sampleDir = __DIR__ . '/samples/EventTest/';
        $filePath = $sampleDir . $fileName;

        $xml = simplexml_load_file($filePath, 'SimpleXMLElement', 0, \CultureFeed_Cdb_Default::CDB_SCHEME_URL);

        return $xml;
    }

    public function testAppendsCdbidAttributeOnlyWhenCdbidIsSet()
    {
        $this->assertEquals(NULL, $this->event->getCdbId());

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
    public function privatePropertyValues() {
        return array(
            array(TRUE),
            array(FALSE),
        );
    }

    /**
     * @dataProvider privatePropertyValues
     */
    public function testAppendsBooleanPrivateProperty($value) {
        $this->assertInternalType('boolean', $this->event->isPrivate());
        $this->assertEquals(FALSE, $this->event->isPrivate());

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

        $this->assertInternalType('boolean', $this->event->isPrivate());
        $this->assertEquals($value, $this->event->isPrivate());
    }

    public function privatePropertySamples() {
        return array(
          array('private.xml', TRUE),
          array('non-private.xml', FALSE),
        );
    }

    /**
     * @dataProvider privatePropertySamples
     * @param $sampleName
     * @param $value
     */
    public function testCreateFromXmlParsesPrivateAttribute($sampleName, $value) {
        $xml = $this->loadSample($sampleName);
        //var_dump($xml->asXML());
        $event = CultureFeed_Cdb_Item_Event::parseFromCdbXml($xml);

        $this->assertEquals($value, $event->isPrivate());
    }

    public function testParseCdbXMLGuideExample6Dot2() {
        $xml = $this->loadSample('cdbxml-guide-example-6-2.xml');

        $event = CultureFeed_Cdb_Item_Event::parseFromCdbXml($xml);

        $this->assertInstanceOf('CultureFeed_Cdb_Item_Event', $event);

        $this->assertEquals('ea37cae2-c91e-4810-89ab-e060432d2b78', $event->getCdbId());
        $this->assertEquals('2010-02-25T00:00:00', $event->getAvailableFrom());
        $this->assertEquals('2010-08-09T00:00:00', $event->getAvailableTo());
        $this->assertEquals('mverdoodt', $event->getCreatedBy());
        $this->assertEquals('2010-07-05T18:28:18', $event->getCreationDate());
        $this->assertEquals('SKB Import:SKB00001_216413', $event->getExternalId());
        $this->assertFalse($event->isParent());
        $this->assertEquals('2010-07-28T13:58:55', $event->getLastUpdated());
        $this->assertEquals('mverdoodt', $event->getLastUpdatedBy());
        $this->assertEquals('SKB Import', $event->getOwner());
        $this->assertEquals(80, $event->getPctComplete());
        $this->assertFalse($event->isPrivate());
        $this->assertTrue($event->isPublished());
        $this->assertEquals('SKB', $event->getValidator());
        $this->assertEquals('approved', $event->getWfStatus());

        $this->assertEquals(18, $event->getAgeFrom());

        $calendar = $event->getCalendar();

        $this->assertInstanceOf('CultureFeed_Cdb_Data_Calendar', $calendar);

        $this->assertCount(1, $calendar);

        $calendar->rewind();
        /** @var CultureFeed_Cdb_Data_Calendar_Timestamp $timestamp */
        $timestamp = $calendar->current();

        $this->assertInstanceOf('CultureFeed_Cdb_Data_Calendar_Timestamp', $timestamp);

        $this->assertEquals('2010-08-01', $timestamp->getDate());

        $this->assertEquals('21:00:00.0000000', $timestamp->getStartTime());

        $this->assertNULL($timestamp->getEndTime());

      $categories = $event->getCategories();
      $this->assertInstanceOf('CultureFeed_Cdb_Data_CategoryList', $categories);

      $this->assertCount(3, $categories);
      $this->assertContainsOnly('CultureFeed_Cdb_Data_Category', $categories);

      /** @var CultureFeed_Cdb_Data_Category $category */
      $categories->rewind();
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
      $this->assertInternalType('array', $mails);
      $this->assertCount(1, $mails);
      $this->assertContainsOnly('CultureFeed_Cdb_Data_Mail', $mails);

      /** @var CultureFeed_Cdb_Data_Mail $mail */
      $mail = reset($mails);
      $this->assertEquals('info@bonnefooi.be', $mail->getMailAddress());
      $this->assertFalse($mail->isForReservations());
      $this->assertFalse($mail->isMainMail());

      $phones = $contact_info->getPhones();
      $this->assertInternalType('array', $phones);
      $this->assertCount(1, $phones);
      $this->assertContainsOnly('CultureFeed_Cdb_Data_Phone', $phones);

      /** @var CultureFeed_Cdb_Data_Phone $phone */
      $phone = reset($phones);
      $this->assertEquals('0487-62.22.31', $phone->getNumber());
      $this->assertFalse($phone->isForReservations());
      $this->assertFalse($phone->isMainPhone());
      // @todo This might be unexpected, verify in the cdbxml spec.
      $this->assertEquals('', $phone->getType());

      $urls = $contact_info->getUrls();
      $this->assertInternalType('array', $urls);
      $this->assertCount(1, $urls);
      $this->assertContainsOnly('CultureFeed_Cdb_Data_Url', $urls);

      /** @var CultureFeed_Cdb_Data_Url $url */
      $url = reset($urls);
      $this->assertEquals('http://www.bonnefooi.be', $url->getUrl());
      $this->assertTrue($url->isMain());
      $this->assertFalse($url->isForReservations());
    }
}
