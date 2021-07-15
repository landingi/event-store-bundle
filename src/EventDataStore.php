<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle;

use Landingi\EventStoreBundle\Event\AccountName;
use Landingi\EventStoreBundle\Event\AccountUuid;
use Landingi\EventStoreBundle\Event\UserEmail;
use Landingi\EventStoreBundle\Event\UserRole;
use Landingi\EventStoreBundle\Event\UserUuid;

interface EventDataStore
{
    public function getUserRole(UserUuid $userUuid): UserRole;

    public function getUserEmail(UserUuid $userUuid): UserEmail;

    public function getAccountName(AccountUuid $accountUuid): AccountName;
}
