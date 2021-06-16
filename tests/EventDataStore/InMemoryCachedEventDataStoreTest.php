<?php

namespace Landingi\EventStoreBundle\EventDataStore;

use Landingi\EventStoreBundle\Event\AccountName;
use Landingi\EventStoreBundle\Event\AccountUuid;
use Landingi\EventStoreBundle\Event\UserEmail;
use Landingi\EventStoreBundle\Event\UserRole;
use Landingi\EventStoreBundle\Event\UserUuid;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class InMemoryCachedEventDataStoreTest extends TestCase
{
    public function testCache(): void
    {
        $userUuid = new UserUuid(Uuid::v4());
        $accountUuid = new AccountUuid(Uuid::v4());
        $cache = new InMemoryCachedEventDataStore(
            $dataStore = new StaticEventDataStore(
                new UserEmail('admin@example.com'),
                new UserRole('ADMIN'),
                new AccountName('Admin')
            )
        );

        // assert data is valid
        self::assertEquals(
            new UserEmail('admin@example.com'),
            $cache->getUserEmail($userUuid)
        );
        self::assertEquals(
            new UserRole('ADMIN'),
            $cache->getUserRole($userUuid)
        );
        self::assertEquals(
            new AccountName('Admin'),
            $cache->getAccountName($accountUuid)
        );

        // change data
        $dataStore->setUserEmail(new UserEmail('user@example.com'));
        $dataStore->setUserRole(new UserRole('USER'));
        $dataStore->setAccountName(new AccountName('User'));

        // assert data is cached
        self::assertEquals(
            new UserEmail('admin@example.com'),
            $cache->getUserEmail($userUuid)
        );
        self::assertEquals(
            new UserRole('ADMIN'),
            $cache->getUserRole($userUuid)
        );
        self::assertEquals(
            new AccountName('Admin'),
            $cache->getAccountName($accountUuid)
        );
    }
}
