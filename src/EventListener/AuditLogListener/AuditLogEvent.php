<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventListener\AuditLogListener;

use JsonSerializable;
use Landingi\EventStoreBundle\Event;
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

final class AuditLogEvent extends Event implements JsonSerializable
{
    private EventName $name;
    private EventData $data;
    private AggregateName $aggregateName;
    private AggregateUuid $aggregateUuid;
    private CreatedAt $createdAt;
    private AccountUuid $accountUuid;
    private AccountName $accountName;
    private UserUuid $userUuid;
    private UserEmail $userEmail;
    private UserRole $userRole;
    private ?SourceIp $sourceIp;
    private ?AccountUuid $subAccountUuid;

    public function __construct(
        CreatedAt $createdAt,
        EventName $name,
        EventData $data,
        AggregateName $aggregateName,
        AggregateUuid $aggregateUuid,
        AccountUuid $accountUuid,
        AccountName $accountName,
        UserUuid $userUuid,
        UserEmail $userEmail,
        UserRole $userRole,
        SourceIp $sourceIp = null,
        AccountUuid $subAccountUuid = null
    ) {
        $this->createdAt = $createdAt;
        $this->name = $name;
        $this->data = $data;
        $this->aggregateName = $aggregateName;
        $this->aggregateUuid = $aggregateUuid;
        $this->accountUuid = $accountUuid;
        $this->userUuid = $userUuid;
        $this->sourceIp = $sourceIp;
        $this->subAccountUuid = $subAccountUuid;
        $this->accountName = $accountName;
        $this->userEmail = $userEmail;
        $this->userRole = $userRole;
        parent::__construct(
            $name,
            $data,
            $aggregateName,
            $aggregateUuid,
            $accountUuid,
            $userUuid,
            $sourceIp,
            $subAccountUuid,
            $createdAt
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'created_at' => $this->createdAt,
            'event_name' => $this->name,
            'event_data' => json_encode($this->data),
            'aggregate_name' => $this->aggregateName,
            'aggregate_uuid' => $this->aggregateUuid,
            'account_uuid' => $this->accountUuid,
            'account_name' => $this->accountName,
            'user_uuid' => $this->userUuid,
            'user_email' => $this->userEmail,
            'user_role' => $this->userRole,
            'event_source_ip' => $this->sourceIp,
            'subaccount_uuid' => $this->subAccountUuid,
        ];
    }
}
