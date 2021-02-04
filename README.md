# event-store-bundle
Landingi Event Store Implementation

## Requirements
* php >= 7.4

## Configuration
### Event Store
Add to your `service.yaml` Event Store service definition

```yaml
Landingi\EventStoreBundle\EventStore\DbalEventStore:
    class: Landingi\EventStoreBundle\EventStore\DbalEventStore
    arguments: ['@doctrine.dbal.default_connection']
```

### Event Listener
Add to your `service.yaml` file definition

```yaml
Landingi\EventStoreBundle\EventStore:
    class: Landingi\EventStoreBundle\EventStore
    arguments: ['@Landingi\EventStoreBundle\EventStore\DbalEventStore']
    calls:
        - [addListener, ['@your-event-listener-service']]
```
