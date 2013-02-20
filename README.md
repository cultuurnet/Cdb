CultuurNet_Cdb aims to be a fluent PHP library for manipulating, serializing 
and deserializing data present in CultuurNet's [CdbXML][cdbxml] format. The library 
currently supports CdbXML 3.1.

History
=======

In its first incarnation during the summer of 2012 this library was an integral part
of a Drupal module called [Culturefeed][culturefeed]. It was developed by [Krimson][krimson],
loosely based on an earlier prototype by [Statik][statik] made somewhere back in 2009.
The library however was meant to be generally useable from the start, and not to be tightly
coupled with a Drupal module. So in February 2013 it was extracted from the Culturefeed module.

Installation
============

You are free to install the CultuurNet_Cdb PHP library in whatever way that fits you.
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

[composer]: http://getcomposer.org
[packagist]: https://packagist.org/packages/cultuurnet/cdb
[psr-0]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
[culturefeed]: https://github.com/cultuurnet/culturefeed
[cdbxml]: http://www.cultuurdatabank.com/CdbXML/
[krimson]: http://www.krimson.be
[statik]: http://www.statik.be
