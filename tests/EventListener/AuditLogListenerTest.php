<?php

namespace Landingi\EventStoreBundle\EventListener;

use Landingi\EventStoreBundle\Event;
use Landingi\EventStoreBundle\Event\AccountName;
use Landingi\EventStoreBundle\Event\AccountUuid;
use Landingi\EventStoreBundle\Event\AggregateName;
use Landingi\EventStoreBundle\Event\AggregateUuid;
use Landingi\EventStoreBundle\Event\EventData;
use Landingi\EventStoreBundle\Event\EventName;
use Landingi\EventStoreBundle\Event\UserEmail;
use Landingi\EventStoreBundle\Event\UserRole;
use Landingi\EventStoreBundle\Event\UserUuid;
use Landingi\EventStoreBundle\EventDataStore\StaticEventDataStore;
use Landingi\EventStoreBundle\EventStore\MemoryEventStore;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class AuditLogListenerTest extends TestCase
{
    public function testItTransformEventToAuditLogEvent(): void
    {
        $listener = new AuditLogListener(
            $dataStore = new StaticEventDataStore(
                new UserEmail('admin@example.com'),
                new UserRole('ADMIN'),
                new AccountName('Admin')
            ),
            $recorder = new MemoryEventStore()
        );
        $listener->onEvent(
            $event = new Event(
                new EventName('foobar'),
                new EventData(['foo' => 'bar']),
                new AggregateName('account'),
                new AggregateUuid(Uuid::v4()),
                new AccountUuid(Uuid::v4()),
                new UserUuid(Uuid::v4()),
            )
        );
        $auditLogEvent = $event->toAuditLogEvent($dataStore);

        self::assertEquals(
            [$auditLogEvent],
            $recorder->getEvents()
        );
    }
}
