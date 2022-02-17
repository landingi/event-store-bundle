<?php

namespace Landingi\EventStoreBundle;

use DateTime;
use Landingi\EventStoreBundle\Event\AccountName;
use Landingi\EventStoreBundle\Event\AccountUuid;
use Landingi\EventStoreBundle\Event\AggregateName;
use Landingi\EventStoreBundle\Event\AggregateUuid;
use Landingi\EventStoreBundle\Event\CreatedAt;
use Landingi\EventStoreBundle\Event\EventData;
use Landingi\EventStoreBundle\Event\EventName;
use Landingi\EventStoreBundle\Event\SourceIp;
use Landingi\EventStoreBundle\Event\UserEmail;
use Landingi\EventStoreBundle\Event\UserRole;
use Landingi\EventStoreBundle\Event\UserUuid;
use Landingi\EventStoreBundle\EventDataStore\StaticEventDataStore;
use Landingi\EventStoreBundle\EventListener\AuditLogListener\AuditLogEvent;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class EventTest extends TestCase
{
    public function testToAuditLogEvent(): void
    {
        $dataStore = new StaticEventDataStore(
            new UserEmail('admin@example.com'),
            new UserRole('ADMIN'),
            new AccountName('Admin')
        );
        $event = new Event(
            new EventName('foo'),
            new EventData(['foo' => 'bar']),
            new AggregateName('account'),
            new AggregateUuid(Uuid::v4()),
            new AccountUuid(Uuid::v4()),
            new UserUuid(Uuid::v4()),
            new SourceIp('0.0.0.0'),
            new AccountUuid(Uuid::v4()),
            new CreatedAt(new DateTime())
        );

        self::assertEquals(
            new AuditLogEvent(
                $event->getCreatedAt(),
                $event->getName(),
                $event->getEventData(),
                $event->getAggregateName(),
                $event->getAggregateUuid(),
                $event->getAccountUuid(),
                $dataStore->getAccountName($event->getAccountUuid()),
                $event->getUserUuid(),
                $dataStore->getUserEmail($event->getUserUuid()),
                $dataStore->getUserRole($event->getUserUuid()),
                $event->getSourceIp(),
                $event->getSubaccountUuid()
            ),
            $event->toAuditLogEvent($dataStore)
        );
    }

    public function testGenerateTimestamp(): void
    {
        $event = new Event(
            new EventName('foo'),
            new EventData(['foo' => 'bar']),
            new AggregateName('account'),
            new AggregateUuid(Uuid::v4()),
            new AccountUuid(Uuid::v4()),
            new UserUuid(Uuid::v4()),
            new SourceIp('0.0.0.0'),
            new AccountUuid(Uuid::v4()),
            new CreatedAt(new DateTime('2022-02-17'))
        );
        $this->assertEquals(1645056000, $event->getCreatedAt()->getTimestamp());
    }
}
