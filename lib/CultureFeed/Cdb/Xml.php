<?php

/**
 * @file
 */
class CultureFeed_Cdb_Xml
{
    /**
     * @deprecated
     *   This constant will be removed in future versions. Use the method
     *   namespaceUriForVersion() instead.
     */
    const DEFAULT_NAMESPACE_URI = 'http://www.cultuurdatabank.com/XMLSchema/CdbXSD/3.2/FINAL';

    /**
     * @var string
     * @deprecated
     */
    private static $namespaceUri = self::DEFAULT_NAMESPACE_URI;

    /**
     * Intentionally made private because class can not be instantiated.
     */
    private function __construct()
    {
    }

    /**
     * @deprecated
     *   This method seems not to be used anywhere by the library and therefore
     *   will be removed in future versions.
     *
     * @return string
     */
    public static function namespaceUri()
    {
        return self::$namespaceUri;
    }

    /**
     * @deprecated
     *   This method seems not to be used anywhere by the library and therefore
     *   will be removed in future versions.
     *
     * @param string $uri
     */
    public static function setNamespaceUri($uri)
    {
        self::$namespaceUri = $uri;
    }

    /**
     * Returns the Cdb XML namespace URI corresponding to a given version.
     *
     * @param $version
     *   The Cdb XML version, for example 3.2, 3.3, ...
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public static function namespaceUriForVersion($version)
    {
        if (!is_string($version)) {
            throw new InvalidArgumentException(
                'Expected string for argument $version, actual: ' . gettype(
                    $version
                )
            );
        }

        return str_replace(
            '{version}',
            $version,
            'http://www.cultuurdatabank.com/XMLSchema/CdbXSD/{version}/FINAL'
        );
    }
}
