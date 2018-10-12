# Tun2U Magento 2 AutoRelated extension

[![Latest Stable Version](https://poser.pugx.org/tun2u/m2-autorelated/v/stable)](https://packagist.org/packages/tun2u/m2-autorelated)
[![Total Downloads](https://poser.pugx.org/tun2u/m2-autorelated/downloads)](https://packagist.org/packages/tun2u/m2-autorelated)
[![License](https://poser.pugx.org/tun2u/m2-autorelated/license)](https://packagist.org/packages/tun2u/m2-autorelated)

Auto generate related products for Magento 2

## Features

* Auto generate related products
* Caching related products
* Supports Magento 2.x

## Installing

##### Manual Installation
Install Tun2U AutoRelated extensions for Magento2
 * Download the extension
 * Unzip the file
 * Create a folder {Magento root}/app/code/Tun2U/AutoRelated
 * Copy the content from the unzip folder
 * Run following command
 ```
 php bin/magento setup:upgrade
 php bin/magento setup:static-content:deploy
 php bin/magento setup:di:compile
 php bin/magento cache:flush
 ```
 * Flush cache

##### Using Composer (from Magento Root Dir run)

```
composer require tun2u/m2_autorelated
php bin/magento setup:static-content:deploy
php bin/magento setup:di:compile
php bin/magento cache:flush
```

## Requirements

- PHP >= 5.3.0

## Compatibility

- Magento >= 2.0

## Support

If you encounter any problems or bugs, please create an issue on [GitHub](https://github.com/Tun2U/M2_AutoRelated/issues).

## Developer

##### Tun2U Team
* Website: [https://www.tun2u.it](https://www.tun2u.it)
* Twitter: [@tun2u](https://twitter.com/tun2u)

## Licence

[GNU General Public License, version 3 (GPLv3)](http://opensource.org/licenses/gpl-3.0)

## Copyright

(c) 2018 Tun2U Team
