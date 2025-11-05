## Hyvä Themes - PayZen Integration

This module enables the use of PayZen payment module with Hyvä Checkout.

## Requirements

Before proceeding with the installation, please ensure that you have installed the PayZen payment module.
The PayZen module for Magento 2 is available for free.

## Installation & upgrade
 - Remove app/code/Lyranetwork/PayzenHyva folder if already exists.
 - Create a new app/code/Lyranetwork/PayzenHyva folder.
 - Unzip module in your Magento 2 app/code/Lyranetwork/PayzenHyva folder.
 - Open command line and change to Magento installation root directory.
 - Enable module: php bin/magento module:enable --clear-static-content Lyranetwork_PayzenHyva
 - Upgrade database: php bin/magento setup:upgrade
 - Re-run compile command: php bin/magento setup:di:compile
 - Update static files by: php bin/magento setup:static-content:deploy [locale]

In order to deactivate the module: php bin/magento module:disable --clear-static-content Lyranetwork_PayzenHyva

## License

Each PayZen payment module source file included in this distribution is licensed under the Open Software License (OSL 3.0).

Please see LICENSE.txt for the full text of the OSL 3.0 license. It is also available through the world-wide-web at this URL: https://opensource.org/licenses/osl-3.0.php.
