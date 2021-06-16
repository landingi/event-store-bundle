<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventListener\AuditLogListener;

use Landingi\EventStoreBundle\Event\AccountUuid;
use Landingi\EventStoreBundle\Event\AggregateName;
use Landingi\EventStoreBundle\Event\AggregateUuid;
use Landingi\EventStoreBundle\Event\CreatedAt;
use Landingi\EventStoreBundle\Event\EventData;
use Landingi\EventStoreBundle\Event\EventName;
use Landingi\EventStoreBundle\Event\SourceIp;
use Landingi\EventStoreBundle\Event\UserUuid;
use Landingi\EventStoreBundle\Event\AccountName;
use Landingi\EventStoreBundle\Event\UserEmail;
use Landingi\EventStoreBundle\Event\UserRole;

final class AuditLogEvent
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
    private ?AccountUuid $subaccountUuid;

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
        AccountUuid $subaccountUuid = null
    ) {
        $this->createdAt = $createdAt;
        $this->name = $name;
        $this->data = $data;
        $this->aggregateName = $aggregateName;
        $this->aggregateUuid = $aggregateUuid;
        $this->accountUuid = $accountUuid;
        $this->userUuid = $userUuid;
        $this->sourceIp = $sourceIp;
        $this->subaccountUuid = $subaccountUuid;
        $this->accountName = $accountName;
        $this->userEmail = $userEmail;
        $this->userRole = $userRole;
    }

    public function getName(): EventName
    {
        return $this->name;
    }

    public function getEventData(): EventData
    {
        return $this->data;
    }

    public function getAggregateName(): AggregateName
    {
        return $this->aggregateName;
    }

    public function getAggregateUuid(): AggregateUuid
    {
        return $this->aggregateUuid;
    }

    public function getCreatedAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function getAccountUuid(): AccountUuid
    {
        return $this->accountUuid;
    }

    public function getAccountName(): AccountName
    {
        return $this->accountName;
    }

    public function getUserUuid(): UserUuid
    {
        return $this->userUuid;
    }

    public function getUserEmail(): UserEmail
    {
        return $this->userEmail;
    }

    public function getUserRole(): UserRole
    {
        return $this->userRole;
    }

    public function getSourceIp(): ?SourceIp
    {
        return $this->sourceIp;
    }

    public function getSubaccountUuid(): ?AccountUuid
    {
        return $this->subaccountUuid;
    }
}
