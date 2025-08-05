<?php

declare(strict_types=1);

final class CultureFeed_Cdb_Xml
{
    /**
     * @deprecated
     *   This constant will be removed in future versions. Use the method
     *   namespaceUriForVersion() instead.
     */
    const DEFAULT_NAMESPACE_URI = 'http://www.cultuurdatabank.com/XMLSchema/CdbXSD/3.2/FINAL';

    /**
     * @deprecated
     */
    private static string $namespaceUri = self::DEFAULT_NAMESPACE_URI;

    private function __construct()
    {
    }

    /**
     * @deprecated
     *   This method seems not to be used anywhere by the library and therefore
     *   will be removed in future versions.
     */
    public static function namespaceUri(): string
    {
        return self::$namespaceUri;
    }

    /**
     * @deprecated
     *   This method seems not to be used anywhere by the library and therefore
     *   will be removed in future versions.
     */
    public static function setNamespaceUri(string $uri): void
    {
        self::$namespaceUri = $uri;
    }

    public static function namespaceUriForVersion(string $version): string
    {
        return str_replace(
            '{version}',
            $version,
            'http://www.cultuurdatabank.com/XMLSchema/CdbXSD/{version}/FINAL'
        );
    }
}
