# TFA Two Factor Authentication 

Two Factor Authentication Extension for Magento 2

### Installation

Run the following commands:
```bash
cd <magento_root>
composer config repositories.swissup composer https://swissup.github.io/packages/
composer require swissup/tfa:dev-master --prefer-source --ignore-platform-reqs
bin/magento module:enable Swissup_Core Swissup_Tfa
bin/magento setup:upgrade
bin/magento setup:static-content:deploy
```
