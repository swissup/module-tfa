# TFA Two Factor Authentication 

Two Factor Authentication Extension for Magento 2

![2018-05-25 17-16-11](https://user-images.githubusercontent.com/412612/40549148-6518bfe8-603f-11e8-9182-7fb5e2d53a1f.png)


#### Server Time
It's extremely important that you keep your server time in sync with some NTP server.


### Installation

Run the following commands:
```bash
cd <magento_root>
composer config repositories.swissup composer https://swissup.github.io/packages/
composer require swissup/tfa:dev-master --prefer-source --ignore-platform-reqs
bin/magento module:enable Swissup_Core Swissup_Tfa
bin/magento setup:upgrade
```

g

![2018-05-25 17-15-34](https://user-images.githubusercontent.com/412612/40549149-65439a1a-603f-11e8-950c-106fbf7590b1.png)

* TFA must be enabled by the individual user by clicking 'Account Setting(user)' in the Magento 2 admin panel.
* Once there, the user is able to enable the two factor authentication and view the QR code for a Google Authenticator compatible application.
* Users with TFA enabled will not be able to log into the admin panel without a valid authentication code input on the Magento 2 admin login page.
* Users with TFA disabled can leave the 'Authenticator Code' field blank during login.

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
