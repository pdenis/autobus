# Autobus - PHP service BUS

## Install

```
composer install
php bin/console d:s:u --force
php bin/console doctrine:fixtures:load
```

## Run (dev)

```
php bin/console server:run
```

## Create a service

To create a new service:

* Create it's class, implementing `BusBundle\Service\BusServiceInterface` ; it may extend `BusBundle\Service\AbstractBusService`
* Declare it as a service in your bundle's `services.yml`, with tag `bus.service`
* Create an instance from the web UI

## Requirements

* PHP 7+
