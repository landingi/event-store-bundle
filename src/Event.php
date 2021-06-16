<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle;

use Landingi\EventStoreBundle\Event\AccountUuid;
use Landingi\EventStoreBundle\Event\AggregateName;
use Landingi\EventStoreBundle\Event\AggregateUuid;
use Landingi\EventStoreBundle\Event\CreatedAt;
use Landingi\EventStoreBundle\Event\EventData;
use Landingi\EventStoreBundle\Event\EventName;
use Landingi\EventStoreBundle\Event\SourceIp;
use Landingi\EventStoreBundle\Event\UserUuid;
use Landingi\EventStoreBundle\EventListener\AuditLogListener\AuditLogEvent;

class Event
{
    private EventName $name;
    private EventData $data;
    private AggregateName $aggregateName;
    private AggregateUuid $aggregateUuid;
    private CreatedAt $createdAt;
    private AccountUuid $accountUuid;
    private UserUuid $userUuid;
    private ?SourceIp $sourceIp;
    private ?AccountUuid $subaccountUuid;

    public function __construct(
        EventName $name,
        EventData $data,
        AggregateName $aggregateName,
        AggregateUuid $aggregateUuid,
        AccountUuid $accountUuid,
        UserUuid $userUuid,
        SourceIp $sourceIp = null,
        AccountUuid $subaccountUuid = null
    ) {
        $this->name = $name;
        $this->data = $data;
        $this->aggregateName = $aggregateName;
        $this->aggregateUuid = $aggregateUuid;
        $this->createdAt = new CreatedAt(new \DateTime());
        $this->accountUuid = $accountUuid;
        $this->userUuid = $userUuid;
        $this->sourceIp = $sourceIp;
        $this->subaccountUuid = $subaccountUuid;
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

    public function getUserUuid(): UserUuid
    {
        return $this->userUuid;
    }

    public function getSourceIp(): ?SourceIp
    {
        return $this->sourceIp;
    }

    public function getSubaccountUuid(): ?AccountUuid
    {
        return $this->subaccountUuid;
    }

    public function toAuditLogEvent(EventDataStore $eventDataStore): AuditLogEvent
    {
        return new AuditLogEvent(
            $this->createdAt,
            $this->name,
            $this->data,
            $this->aggregateName,
            $this->aggregateUuid,
            $this->accountUuid,
            $eventDataStore->getAccountName($this->accountUuid),
            $this->userUuid,
            $eventDataStore->getUserEmail($this->userUuid),
            $eventDataStore->getUserRole($this->userUuid),
            $this->sourceIp,
            $this->subaccountUuid
        );
    }

    public function __toString(): string
    {
        return (string) $this->name;
    }
}
