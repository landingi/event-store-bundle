# event-store-bundle
Landingi Event Store Implementation

[![Build Status](https://travis-ci.com/landingi/event-store-bundle.svg?branch=master)](https://travis-ci.com/landingi/event-store-bundle)
[![License MIT](https://img.shields.io/apm/l/vim-mode.svg)](https://opensource.org/licenses/MIT)
![Packagist Version](https://img.shields.io/packagist/v/landingi/event-store-bundle)


## Requirements
* php >= 7.4
* Doctrine 2.0 || 3.0
* Symfony >= 5.2

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

## Bundle auto-configuration

1. To `config/packages` add `landingi_event_store.yaml` with following content
```yaml
landingi_event_store:
  event_store:
    connection: 'doctrine.dbal.default_connection' # landingi_production DB connection
  auditlog:
    enabled: true                # set to false to disable AuditLogListener
    endpoint: 'http://audit-log' # base URL endpoint for SymfonyHttpAuditLogStore
    client: 'http_client'        # instance of Symfony\Contracts\HttpClient\HttpClientInterface interface
    strict_mode: true            # set to false to ignore StrictAuditLogListener allowed events list
```

2. To `config/bundles.php` add:
```php
Landingi\EventStoreBundle\LandingiEventStoreBundle::class => ['all' => true]
```
