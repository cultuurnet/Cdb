<?php

class CultureFeed_Cdb_Data_MediaTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CultureFeed_Cdb_Data_Media
     */
    protected $media;

    public function setUp()
    {
        $this->media = new CultureFeed_Cdb_Data_Media();
    }

    public function testImplementsCountable()
    {

        $this->assertInstanceOf('\Countable', $this->media);
    }

    public function testCountIs0OnNewInstance()
    {
        $this->assertInstanceOf('\Countable', $this->media);
        $this->assertCount(0, $this->media);
    }

    public function testAddingFilesIncrementsCount()
    {
        $toAdd = range(1, 10);

        $expectedCountAfterAdding = count($this->media);

        foreach ($toAdd as $i) {
            $expectedCountAfterAdding++;
            $file = $this->randomPhotoFile();
            $this->media->add($file);

            $this->assertCount($expectedCountAfterAdding, $this->media);
        }
    }

    protected function randomPhotoFile()
    {
        $file = new CultureFeed_Cdb_Data_File();
        $file->setMediaType($file::MEDIA_TYPE_PHOTO);
        $file->setHLink($this->randomImageUrl());
        return $file;
    }

    protected function randomWebResourceFile()
    {
        $file = new CultureFeed_Cdb_Data_File();
        $file->setMediaType($file::MEDIA_TYPE_WEBRESOURCE);
        $file->setHLink($this->randomImageUrl());
        return $file;
    }

    protected function randomImageUrl()
    {
        $categories = array(
            'abstract',
            'city',
            'people',
            'transport',
            'animals',
            'food',
            'nature',
            'business',
            'nightlife',
            'sports',
            'cats',
            'fashion',
            'technics',
        );
        $category = array_rand($categories);
        $number = rand(1, 10);

        $url = "http://lorempixel.com/400/200/{$category}/{$number}";

        return $url;
    }

    public function testCanFilterByMediaType()
    {
        $picture1 = $this->randomPhotoFile();
        $picture2 = $this->randomPhotoFile();
        $picture3 = $this->randomPhotoFile();

        $uri1 = $this->randomWebResourceFile();
        $uri2 = $this->randomWebResourceFile();

        $this->media->add($picture2);
        $this->media->add($uri1);
        $this->media->add($picture3);
        $this->media->add($picture1);
        $this->media->add($uri2);

        $pictures = $this->media->byMediaType(
            CultureFeed_Cdb_Data_File::MEDIA_TYPE_PHOTO
        );
        $this->assertInstanceOf('\CultureFeed_Cdb_Data_Media', $pictures);
        $this->assertContainsOnly('\CultureFeed_Cdb_Data_File', $pictures);
        $this->assertCount(3, $pictures);

        $pictures->rewind();
        $this->assertEquals($picture2, $pictures->current());
        $pictures->next();
        $this->assertEquals($picture3, $pictures->current());
        $pictures->next();
        $this->assertEquals($picture1, $pictures->current());

        $uris = $this->media->byMediaType(
            CultureFeed_Cdb_Data_File::MEDIA_TYPE_WEBRESOURCE
        );
        $this->assertInstanceOf('\CultureFeed_Cdb_Data_Media', $uris);
        $this->assertContainsOnly('\CultureFeed_Cdb_Data_File', $uris);
        $this->assertCount(2, $uris);

        $uris->rewind();
        $this->assertEquals($uri1, $uris->current());
        $uris->next();
        $this->assertEquals($uri2, $uris->current());
    }
}
