# event-store-bundle
Landingi Event Store Implementation

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
