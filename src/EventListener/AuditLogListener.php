<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventListener;

use Landingi\EventStoreBundle\Event;
use Landingi\EventStoreBundle\EventListener;
use Landingi\EventStoreBundle\EventListener\AuditLogListener\AuditLogClient;
use Landingi\EventStoreBundle\EventDataStore;

final class AuditLogListener implements EventListener
{
    private EventDataStore $auditLogEventData;
    private AuditLogClient $auditLogClient;

    public function __construct(EventDataStore $auditLogEventData, AuditLogClient $auditLogClient)
    {
        $this->auditLogEventData = $auditLogEventData;
        $this->auditLogClient = $auditLogClient;
    }

    public function onEvent(Event $event): void
    {
        $this->auditLogClient->store(
            $event->toAuditLogEvent(
                $this->auditLogEventData
            )
        );
    }
}
