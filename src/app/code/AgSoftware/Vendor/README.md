# Mage2 Module AgSoftware Vendor

    ``agsoftware/module-vendor``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
none

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/AgSoftware`
 - Enable the module by running `php bin/magento module:enable AgSoftware_Vendor`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require agsoftware/module-vendor`
 - enable the module by running `php bin/magento module:enable AgSoftware_Vendor`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration




## Specifications

 - Controller
	- frontend > vendor/index/index

 - Controller
	- frontend > vendor/products/index

 - Controller
	- frontend > vendor/sales/index

 - Controller
	- frontend > vendor/settings/index

 - Controller
	- frontend > vendor/products/edit

 - Controller
	- frontend > vendor/products/create

 - Controller
	- frontend > vendor/products/view

 - Controller
	- frontend > vendor/products/save

 - Controller
	- frontend > vendor/products/delete

 - Controller
	- frontend > vendor/sales/view

 - Controller
	- frontend > vendor/settings/save

 - Plugin
	- afterGetValue - Magento\Framework\App\Config\ScopeConfigInterface > AgSoftware\Vendor\Plugin\Magento\Framework\App\Config\ScopeConfigInterface


## Attributes

 - Customer - Vendor (agsoftware_vendor)

 - Customer - Subscription (agsoftware_subscription)

 - Product - Vendor (agsoftware_vendor_id)

