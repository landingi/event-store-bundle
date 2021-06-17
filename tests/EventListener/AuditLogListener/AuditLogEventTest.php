<?php

namespace Landingi\EventStoreBundle\EventListener\AuditLogListener;

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
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class AuditLogEventTest extends TestCase
{
    public function testJsonSerialize(): void
    {
        self::assertJsonStringEqualsJsonString(
            (string) json_encode([
                'created_at' => '2021-01-01 12:00:00',
                'event_name' => 'foo',
                'event_data' => '{"foo":"bar"}',
                'aggregate_name' => 'account',
                'aggregate_uuid' => '567dc1cc-cf5e-11eb-b8bc-0242ac130003',
                'account_uuid' => '5f1998ba-cf5e-11eb-b8bc-0242ac130003',
                'account_name' => 'ADMIN',
                'user_uuid' => '67d42ee8-cf5e-11eb-b8bc-0242ac130003',
                'user_email' => 'admin@example.com',
                'user_role' => 'admin',
                'event_source_ip' => '0.0.0.0',
                'subaccount_uuid' => '737d2a42-cf5e-11eb-b8bc-0242ac130003',
            ]),
            (string) json_encode(
                new AuditLogEvent(
                    new CreatedAt(new DateTime('2021-01-01 12:00:00')),
                    new EventName('foo'),
                    new EventData(['foo' => 'bar']),
                    new AggregateName('account'),
                    new AggregateUuid(Uuid::fromString('567dc1cc-cf5e-11eb-b8bc-0242ac130003')),
                    new AccountUuid(Uuid::fromString('5f1998ba-cf5e-11eb-b8bc-0242ac130003')),
                    new AccountName('ADMIN'),
                    new UserUuid(Uuid::fromString('67d42ee8-cf5e-11eb-b8bc-0242ac130003')),
                    new UserEmail('admin@example.com'),
                    new UserRole('admin'),
                    new SourceIp('0.0.0.0'),
                    new AccountUuid(Uuid::fromString('737d2a42-cf5e-11eb-b8bc-0242ac130003')),
                )
            )
        );
    }

    public function testJsonSerializeWithoutSubAccountAndSourceIp(): void
    {
        self::assertJsonStringEqualsJsonString(
            (string) json_encode([
                'created_at' => '2021-01-01 12:00:00',
                'event_name' => 'foo',
                'event_data' => '{"foo":"bar"}',
                'aggregate_name' => 'account',
                'aggregate_uuid' => '567dc1cc-cf5e-11eb-b8bc-0242ac130003',
                'account_uuid' => '5f1998ba-cf5e-11eb-b8bc-0242ac130003',
                'account_name' => 'ADMIN',
                'user_uuid' => '67d42ee8-cf5e-11eb-b8bc-0242ac130003',
                'user_email' => 'admin@example.com',
                'user_role' => 'admin',
                'event_source_ip' => null,
                'subaccount_uuid' => null,
            ]),
            (string) json_encode(
                new AuditLogEvent(
                    new CreatedAt(new DateTime('2021-01-01 12:00:00')),
                    new EventName('foo'),
                    new EventData(['foo' => 'bar']),
                    new AggregateName('account'),
                    new AggregateUuid(Uuid::fromString('567dc1cc-cf5e-11eb-b8bc-0242ac130003')),
                    new AccountUuid(Uuid::fromString('5f1998ba-cf5e-11eb-b8bc-0242ac130003')),
                    new AccountName('ADMIN'),
                    new UserUuid(Uuid::fromString('67d42ee8-cf5e-11eb-b8bc-0242ac130003')),
                    new UserEmail('admin@example.com'),
                    new UserRole('admin'),
                )
            )
        );
    }
}
