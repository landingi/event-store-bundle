<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventDataStore;

use Landingi\EventStoreBundle\Event\AccountName;
use Landingi\EventStoreBundle\Event\AccountUuid;
use Landingi\EventStoreBundle\Event\UserEmail;
use Landingi\EventStoreBundle\Event\UserRole;
use Landingi\EventStoreBundle\Event\UserUuid;
use Landingi\EventStoreBundle\EventDataStore;

final class InMemoryCachedEventDataStore implements EventDataStore
{
    private EventDataStore $eventDataStore;
    private array $cache;

    public function __construct(EventDataStore $eventDataStore)
    {
        $this->eventDataStore = $eventDataStore;
        $this->cache = [];
    }

    public function getUserRole(UserUuid $userUuid): UserRole
    {
        if (false === isset($this->cache[(string) $userUuid]['role'])) {
            $this->cache[(string) $userUuid]['role'] = $this->eventDataStore->getUserRole($userUuid);
        }

        return $this->cache[(string) $userUuid]['role'];
    }

    public function getUserEmail(UserUuid $userUuid): UserEmail
    {
        if (false === isset($this->cache[(string) $userUuid]['email'])) {
            $this->cache[(string) $userUuid]['email'] = $this->eventDataStore->getUserEmail($userUuid);
        }

        return $this->cache[(string) $userUuid]['email'];
    }

    public function getAccountName(AccountUuid $accountUuid): AccountName
    {
        if (false === isset($this->cache[(string) $accountUuid]['name'])) {
            $this->cache[(string) $accountUuid]['name'] = $this->eventDataStore->getAccountName($accountUuid);
        }

        return $this->cache[(string) $accountUuid]['name'];
    }
}
