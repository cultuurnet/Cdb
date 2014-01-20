<?php
/**
 * @file
 */

class CultureFeed_Cdb_Xml {

  const DEFAULT_NAMESPACE_URI = 'http://www.cultuurdatabank.com/XMLSchema/CdbXSD/3.2/FINAL';

  private static $namespaceUri = self::DEFAULT_NAMESPACE_URI;

  public static function namespaceUri() {
    return self::$namespaceUri;
  }

  public static function setNamespaceUri($uri) {
    self::$namespaceUri = $uri;
  }
}
