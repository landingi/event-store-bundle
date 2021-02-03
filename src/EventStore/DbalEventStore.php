<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventStore;

use Doctrine\DBAL\Connection;
use Landingi\EventStoreBundle\Event;
use Landingi\EventStoreBundle\EventStore;

final class DbalEventStore implements EventStore
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     * @throws \JsonException
     */
    public function store(Event $event): void
    {
        $this->connection->insert('events_store', [
            'account_uuid' => $event->getAccountUuid()->jsonSerialize(),
            'aggregate_name' => $event->getAggregateName()->jsonSerialize(),
            'aggregate_uuid' => $event->getAggregateUuid()->jsonSerialize(),
            'created_at' => $event->getCreatedAt()->jsonSerialize(),
            'event_name' => $event->getName()->jsonSerialize(),
            'event_data' => json_encode($event->getEventData()->jsonSerialize(), JSON_THROW_ON_ERROR),
            'event_source_ip' => $event->getSourceIp() ? $event->getSourceIp()->jsonSerialize() : null,
            'subaccount_uuid' => $event->getSubaccountUuid() ? $event->getSubAccountUuid()->jsonSerialize() : null,
            'user_uuid' => $event->getUserUuid()->jsonSerialize(),
        ]);
    }
}
