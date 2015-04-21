<?php
/**
 * @file
 */

class CultureFeed_Cdb_Data_KeywordTest extends PHPUnit_Framework_TestCase {

  public function testIsVisibleByDefault() {
    $keyword = new CultureFeed_Cdb_Data_Keyword('foo');

    $this->assertTrue($keyword->isVisible());
  }
}
