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

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getUserRole(UserUuid $userUuid): UserRole
    {
        return new UserRole($this->fetchUserData($userUuid)['role']);
    }

    public function getUserEmail(UserUuid $userUuid): UserEmail
    {
        return new UserEmail($this->fetchUserData($userUuid)['email']);
    }

    public function getAccountName(AccountUuid $accountUuid): AccountName
    {
        return new AccountName($this->fetchAccountData($accountUuid));
    }

    private function fetchUserData(UserUuid $userUuid): array
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

        return $result;
    }

    private function fetchAccountData(AccountUuid $accountUuid): string
    {
        $query = $this->connection->createQueryBuilder();
        $query->select('name');
        $query->from('accounts');
        $query->where('uuid = :account_uuid');
        $query->setParameter('account_uuid', (string) $accountUuid);
        return (string) $this->connection->executeQuery(
            $query->getSQL(),
            $query->getParameters()
        )->fetchOne();
    }
}
