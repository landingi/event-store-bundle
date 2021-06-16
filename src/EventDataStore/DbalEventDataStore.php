<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventDataStore;

use Doctrine\DBAL\Connection;
use Landingi\EventStoreBundle\Event\AccountName;
use Landingi\EventStoreBundle\Event\AccountUuid;
use Landingi\EventStoreBundle\Event\UserEmail;
use Landingi\EventStoreBundle\Event\UserRole;
use Landingi\EventStoreBundle\Event\UserUuid;
use Landingi\EventStoreBundle\EventDataStore;
use RuntimeException;

final class DbalEventDataStore implements EventDataStore
{
    private Connection $connection;
    private array $cache;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->cache = [];
    }

    public function getUserRole(UserUuid $userUuid): UserRole
    {
        if (false === isset($this->cache[(string) $userUuid])) {
            $this->fetchUserData($userUuid);
        }

        return new UserRole($this->cache[(string) $userUuid]['role']);
    }

    public function getUserEmail(UserUuid $userUuid): UserEmail
    {
        if (false === isset($this->cache[(string) $userUuid])) {
            $this->fetchUserData($userUuid);
        }

        return new UserEmail($this->cache[(string) $userUuid]['email']);
    }

    public function getAccountName(AccountUuid $accountUuid): AccountName
    {
        if (false === isset($this->cache[(string) $accountUuid])) {
            $this->fetchAccountData($accountUuid);
        }

        return new AccountName($this->cache[(string) $accountUuid]['email']);
    }

    private function fetchUserData(UserUuid $userUuid): void
    {
        $query = $this->connection->createQueryBuilder();
        $query->select('email, role');
        $query->from('users');
        $query->where('uuid = :user_uuid');
        $query->setParameter('user_uuid', (string) $userUuid);
        $result = $this->connection->executeQuery(
            $query->getSQL(),
            $query->getParameters()
        )->fetchAssociative();

        if (false === is_array($result)) {
            throw new RuntimeException("Could not fetch user data for UUID: $userUuid");
        }

        $this->cache[(string) $userUuid] = $result;
    }

    private function fetchAccountData(AccountUuid $accountUuid): void
    {
        $query = $this->connection->createQueryBuilder();
        $query->select('name');
        $query->from('accounts');
        $query->where('uuid = :account_uuid');
        $query->setParameter('account_uuid', (string) $accountUuid);
        $result = $this->connection->executeQuery(
            $query->getSQL(),
            $query->getParameters()
        )->fetchAssociative();

        if (false === is_array($result)) {
            throw new RuntimeException("Could not fetch account data for UUID: $accountUuid");
        }

        $this->cache[(string) $accountUuid] = $result;
    }
}
