<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventListener\AuditLogListener\AuditLogClient;

use Landingi\EventStoreBundle\EventListener\AuditLogListener\AuditLogClient;
use Landingi\EventStoreBundle\EventListener\AuditLogListener\AuditLogEvent;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SymfonyHttpAuditLogClient implements AuditLogClient
{
    private string $auditLogApiBaseUrl;
    private HttpClientInterface $httpClient;

    public function __construct(string $auditLogApiBaseUrl, HttpClientInterface $httpClient)
    {
        $this->auditLogApiBaseUrl = $auditLogApiBaseUrl;
        $this->httpClient = $httpClient;
    }

    public function store(AuditLogEvent $event): void
    {
        $this->httpClient->request(
            'POST',
            "{$this->auditLogApiBaseUrl}/v1/events",
            [
                'json' => [
                    'event_name' => $event->getName(),
                    'event_data' => $event->getEventData(),
                    'event_source_ip' => $event->getSourceIp(),
                    'aggregate_name' => $event->getAggregateName(),
                    'aggregate_uuid' => $event->getAggregateUuid(),
                    'account_uuid' => $event->getAccountUuid(),
                    'account_name' => $event->getAccountName(),
                    'subaccount_uuid' => $event->getSubaccountUuid(),
                    'user_uuid' => $event->getUserUuid(),
                    'user_email' => $event->getUserEmail(),
                    'user_role' => $event->getUserRole(),
                    'created_at' => $event->getCreatedAt(),
                ]
            ]
        );
    }
}
