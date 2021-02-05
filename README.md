# event-store-bundle
Landingi Event Store Implementation

[![Build Status](https://travis-ci.com/landingi/event-store-bundle.svg?branch=master)](https://travis-ci.com/landingi/event-store-bundle)
[![License MIT](https://img.shields.io/apm/l/vim-mode.svg)](https://opensource.org/licenses/MIT)
![Packagist Version](https://img.shields.io/packagist/v/landingi/event-store-bundle)


## Requirements
* php >= 7.4

## Configuration
### Event Store
Add to your `service.yaml` Event Store service definition

```yaml
landingi.event-store.dbal:
    class: Landingi\EventStoreBundle\EventStore\DbalEventStore
    arguments: ['@doctrine.dbal.default_connection']

Landingi\EventStoreBundle\EventStore:
    class: Landingi\EventStoreBundle\EventStore\ListenerEventStore
    arguments: ['@landingi.event-store.dbal']
    calls:
        - [addListener, ['@your-event-listener-service']]
```
