CultuurNet\Cdb aims to be a fluent PHP library for manipulating, serializing
and deserializing data present in CultuurNet's [CdbXML][cdbxml] format. The library
currently supports CdbXML 3.1.

History
=======

In its first incarnation during the summer of 2012 this library was an integral part
of a Drupal module called [Culturefeed][culturefeed]. It was developed by [Krimson][krimson],
loosely based on an earlier prototype by [Statik][statik] made somewhere back in 2009.
The library however was meant to be generally useable from the start, and not to be tightly
coupled with a Drupal module. So in February 2013 it was extracted from the Culturefeed module.

To keep backwards compatible breaks to a minimum, the PEAR-style naming conventions were maintained
and classes kept their historical CultureFeed_Cdb prefix. In a later major release, they'll probably
 be renamed and use the PHP 5.3 CultuurNet\Cdb namespace instead.

Installation
============

You are free to install the CultuurNet\Cdb PHP library in whatever way that fits you.
However, we recommend to use [Composer][composer].

Require the cultuurnet/cdb package (it is [registered on Packagist][packagist]) in
your project's composer.json file.

```json
{
    "require": {
        "cultuurnet/cdb": "1.0.*@dev",
    }
}
```

Then run ``composer install``

The library is [PSR-0][psr-0] compliant, so you can load its classes with any
PSR-0 compliant autoloader. If you are using Composer, you can simply
include the autoloader Composer generated.

When using Drupal, there is a very simple way to use the autoloader of Composer.
Just include it in the settings.php file of your site:

```php
require 'vendor/autoload.php';
```

Backwards Compatibility
=======================

This section contains information regarding possible backwards compatibility breaks, and outlines
the necessary steps for upgrading third party code using the CultuurNet\Cdb library.

2013-01-23
----------

### Removal of CultureFeed_SimpleXMLElement dependency ###

All occurrences of CultureFeed_SimpleXMLElement were replaced by SimpleXMLElement, because none
of the additional features of CultureFeed_SimpleXMLElement were actually used. As
CultureFeed_SimpleXMLElement in the Drupal CultureFeed module extends SimpleXMLElement, this
change should normally not have any effect on existing code. If you still encounter issues by this
change, please let us know!

### Renamed classes for PSR-0 compliance ###

For PSR-0 compliance some classes had to be renamed:

- CultureFeed_Cdb_Data_VirtualAddress became CultureFeed_Cdb_Data_Address_VirtualAddress
- CultureFeed_Cdb_Data_PhysicalAddress became CultureFeed_Cdb_Data_Address_PhysicalAddress

Third party code should use the new classes which are functionally identical.

### CultureFeed_Cdb_Item_Event::parseFromCdbXml() logic change ###

CultureFeed_Cdb_Item_Event::parseFromCdbXml() used to expect a SimpleXMLElement argument
containing an events element, and parsed the first event element inside that events element.
However, CultureFeed_Cdb_Item_Event is supposed to represent a single event, and therefore
CultureFeed_Cdb_Item_Event::parseFromCdbXml() should only have expectations about a single
'event' XML element and its contents, in line with how the other classes in the CultuurNet\Cdb
library handle parsing from XML. Third party code should from now on pass a single event
XML element to CultureFeed_Cdb_Item_Event::parseFromCdbXml().

### Event external ID vs. CdbId ###
When parsing CdbXML with CultureFeed_Cdb_Item_Event::parseFromCdbXml(), the CdbId was erroneously set as
the external Id with CultureFeed_Cdb_Item_Event::setExternalId(). Third party code could use
CultureFeed_Cdb_Item_event::getExternalId() to get the CdbId. From now on the CdbId should be retrieved with
CultureFeed_Cdb_Item_event::getCdbId() or set with CultureFeed_Cdb_Item_event::setCdbId().
CultureFeed_Cdb_Item_event::getExternalId() and CultureFeed_Cdb_Item_event::setExternalId()
exclusively used to retrieve and set the external ID of an event, NOT the CdbId.

[composer]: http://getcomposer.org
[packagist]: https://packagist.org/packages/cultuurnet/cdb
[psr-0]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
[culturefeed]: https://github.com/cultuurnet/culturefeed
[cdbxml]: http://www.cultuurdatabank.com/CdbXML/
[krimson]: http://www.krimson.be
[statik]: http://www.statik.be
