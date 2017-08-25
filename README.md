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

## Running async jobs

### Queue jobs

**TODO**

### Cron jobs

Add the following line to your crontab:

```
* * * * * php bin/console autobus:cron:run
```

## Create a job

To create a new job:

* Create it's class, implementing `Autobus\Bundle\BusBundle\Runner\RunnerInterface` ; it may extend `Autobus\Bundle\BusBundle\Runner\AbstractRunner`
* Declare it as a service in your bundle's `services.yml`, with tag `bus.runner`
* Create an instance from the web UI

## Requirements

* PHP 7+
