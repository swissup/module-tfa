# TFA Two Factor Authentication

Two Factor Authentication Extension for Magento 2

![2018-05-25 17-16-11](https://user-images.githubusercontent.com/412612/40549148-6518bfe8-603f-11e8-9182-7fb5e2d53a1f.png)

#### Server Time
It's extremely important that you keep your server time in sync with some NTP server.

### Installation

#### For clients

There are several ways to install extension for clients:

 1. If you've bought the product at Magento's Marketplace - use
    [Marketplace installation instructions](https://docs.magento.com/marketplace/user_guide/buyers/install-extension.html)
 2. Otherwise, you have two options:
    - Install the sources directly from [our repository](https://docs.swissuplabs.com/m2/extensions/improvedadminsecurity/installation/composer/) - **recommended**
    - Download archive and use [manual installation](https://docs.swissuplabs.com/m2/extensions/improvedadminsecurity/installation/manual/)

#### For developers

Use this approach if you have access to our private repositories!

Run the following commands:
```bash
cd <magento_root>
composer config repositories.swissup composer https://docs.swissuplabs.com/packages/
composer require swissup/tfa --prefer-source --ignore-platform-reqs
bin/magento module:enable Swissup_Core Swissup_Tfa
bin/magento setup:upgrade
```

![2018-05-25 17-15-34](https://user-images.githubusercontent.com/412612/40549149-65439a1a-603f-11e8-950c-106fbf7590b1.png)

* TFA must be enabled by the individual user by clicking 'Account Setting(user)' in the Magento 2 admin panel.
* Once there, the user is able to enable the two factor authentication and view the QR code for a Google Authenticator compatible application.
* Users with TFA enabled will not be able to log into the admin panel without a valid authentication code input on the Magento 2 admin login page.
* Users with TFA disabled can leave the 'Authenticator Code' field blank during login.

### Activating the extension

* Open your admin user account settins at `System > Permisions > All Users >
Your User > Tab "Two Factor Authentication"`

* Scan QR code with Google Authenticator application using your smartphone.

* Insert the key you've got on your mobile device into the verification key field.

* That's all. You've enabled the protection for that admin user. Try logout
and login with verification key. Please notice that key is got refreshed every
30 seconds. In case you have not enabled the protection for some users, the
verification key will be ignored for those users.

### Google Authenticator Apps:

To use the two factor authentication, your user will have to install a Google Authenticator compatible app, those are some of the currently available:

* [Authy for iOS, Android, Chrome, OS X](https://www.authy.com/)
* [FreeOTP for iOS, Android and Pebble](https://apps.getpebble.com/en_US/application/52f1a4c3c4117252f9000bb8)
* [Google Authenticator for iOS](https://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8)
* [Google Authenticator for Android](https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2)
* [Google Authenticator (port) on Windows Store](https://www.microsoft.com/en-us/store/p/google-authenticator/9wzdncrdnkrf)
* [Microsoft Authenticator for Windows Phone](https://www.microsoft.com/en-us/store/apps/authenticator/9wzdncrfj3rj)
* [LastPass Authenticator for iOS, Android, OS X, Windows](https://lastpass.com/auth/)
* [1Password for iOS, Android, OS X, Windows](https://1password.com)

## Console Commands
TFA can be disabled using console commands if needed:
##### List TFA status For All Admin Users
```bash
php bin/magento swissup:tfa:list
```
##### Disable TFA For Single Admin User (by email)
```bash
php bin/magento swissup:tfa:disable admin@example.com
```
