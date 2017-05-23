# yii2-itam-module

ITAM - IT Asset Manager module for [Yii2](www.yiiframework.com).

To use this module you must install it on an Yii2 application. If you don't have one, checkout [this one]().

## Description

The purpose of this module is to allow IT administrators to manage IT assets. Both hardware and software assets are supported.
There is also a monitoring module to help monitor important assets like servers and switches.

The following hardware assets are currently supported:

* Servers
* Smartphones
* Switches
* Workstations

The following software assets and its licenses are currently supported:

* OS - Operational Systems
* Office Suites
* Other Softwares

Reports are available to help the IT manager control licenses usage.

## Instalation

### Web Application

The prefered method to install is using composer.
```
composer require "marqu3s/yii2-itam-module:dev-master"
```

You can simply add this to `require` section your composer.json file:
```
"marqu3s/yii2-itam-module": "dev-master"
```

Then add this to your ***web*** application `main.php` config file:
````
'modules' => [
    'itam' => [
        'class' => 'marqu3s\itam\Module',
        'rbacAuthorization' => true,
        'nmapPath' => '/usr/bin/'   // Set this to the path of the nmap executable on your system.
    ],
],
````

***NOTE:*** It's a good idea to initialy set `rbacAuthorization` to `false` so you can acess the admin setup page and create the authorization stuff.
Then enable the `rbacAuthorization` setting it to `true`.


### Console Application (Monitoring)

To use the monitoring console commands, add this to your ***console*** application `main.php` config file:
````
'controllerMap' => [
    'itam-monitoring' => [
        'class' => 'marqu3s\itam\console\controllers\MonitoringController',
        'nmapPath' => '/usr/bin/',
        'pushbulletAPIKey' => '',
        'pushbulletChannelTag' => '',
        'pushoverUserKey' => '',
        'pushoverAPIKey' => '',
    ],
],

````

Notifications about assets going down or up are currently sent thru [Pushbullet](https://www.pushbullet.com) or [Pushover](https://pushover.net).
Everybody are welcome to add other notification providers and enhance this module.


## Future Enhancements

* Better setup wizard (mainly the creation of tables in DB and some setup instructions)
* New types of assets
    * Wi-Fi APs
    * IP Cameras
    * Projectors
    * WAN Links
