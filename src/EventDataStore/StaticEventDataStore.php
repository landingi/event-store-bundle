<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventDataStore;

use Landingi\EventStoreBundle\Event\AccountName;
use Landingi\EventStoreBundle\Event\AccountUuid;
use Landingi\EventStoreBundle\Event\UserEmail;
use Landingi\EventStoreBundle\Event\UserRole;
use Landingi\EventStoreBundle\Event\UserUuid;
use Landingi\EventStoreBundle\EventDataStore;

final class StaticEventDataStore implements EventDataStore
{
    private UserEmail $userEmail;
    private UserRole $userRole;
    private AccountName $accountName;

    public function __construct(
        UserEmail $userEmail,
        UserRole $userRole,
        AccountName $accountName
    ) {
        $this->userEmail = $userEmail;
        $this->userRole = $userRole;
        $this->accountName = $accountName;
    }

    public function getUserEmail(UserUuid $userUuid): UserEmail
    {
        return $this->userEmail;
    }

    public function getUserRole(UserUuid $userUuid): UserRole
    {
        return $this->userRole;
    }

    public function getAccountName(AccountUuid $accountUuid): AccountName
    {
        return $this->accountName;
    }

    public function setUserEmail(UserEmail $userEmail): void
    {
        $this->userEmail = $userEmail;
    }

    public function setUserRole(UserRole $userRole): void
    {
        $this->userRole = $userRole;
    }

    public function setAccountName(AccountName $accountName): void
    {
        $this->accountName = $accountName;
    }
}
