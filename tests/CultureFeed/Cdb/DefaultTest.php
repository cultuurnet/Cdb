<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CultureFeed_Cdb_Default_DefaultTest extends TestCase
{
    /**
     * @return array<array<string>>
     */
    public function versionProvider(): array
    {
        return [
            ['3.1'],
            ['3.2'],
            ['3.3'],
        ];
    }

    /**
     * @dataProvider versionProvider
     */
    public function testConstructorWithSpecificVersion(string $version): void
    {
        $cdbXml = new CultureFeed_Cdb_Default($version);
        $this->assertEquals(
            CultureFeed_Cdb_Xml::namespaceUriForVersion($version),
            $cdbXml->getSchemaUrl()
        );
        $this->assertEquals($version, $cdbXml->getSchemaVersion());
    }

    public function testConstructorWithoutSpecificVersion(): void
    {
        $cdbXml = new CultureFeed_Cdb_Default();
        $this->assertEquals(
            CultureFeed_Cdb_Xml::namespaceUriForVersion('3.2'),
            $cdbXml->getSchemaUrl()
        );
        $this->assertEquals('3.2', $cdbXml->getSchemaVersion());
    }
}
