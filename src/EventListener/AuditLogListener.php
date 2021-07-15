<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventListener;

use Landingi\EventStoreBundle\Event;
use Landingi\EventStoreBundle\EventDataStore;
use Landingi\EventStoreBundle\EventListener;
use Landingi\EventStoreBundle\EventStore;

final class AuditLogListener implements EventListener
{
    private EventDataStore $auditLogEventData;
    private EventStore $eventStore;

    public function __construct(EventDataStore $auditLogEventData, EventStore $eventStore)
    {
        $this->auditLogEventData = $auditLogEventData;
        $this->eventStore = $eventStore;
    }

    public function onEvent(Event $event): void
    {
        $this->eventStore->store(
            $event->toAuditLogEvent(
                $this->auditLogEventData
            )
        );
    }
}
