<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventListener\AuditLogListener\AuditLogClient;

use Landingi\EventStoreBundle\EventListener\AuditLogListener\AuditLogClient;
use Landingi\EventStoreBundle\EventListener\AuditLogListener\AuditLogEvent;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SymfonyHttpAuditLogClient implements AuditLogClient
{
    private string $auditLogApiBaseUrl;
    private HttpClientInterface $auditLogApiHttpClient;

    public function __construct(string $auditLogApiBaseUrl, HttpClientInterface $auditLogApiHttpClient)
    {
        $this->auditLogApiBaseUrl = $auditLogApiBaseUrl;
        $this->auditLogApiHttpClient = $auditLogApiHttpClient;
    }

    public function store(AuditLogEvent $event): void
    {
        $this->auditLogApiHttpClient->request(
            'POST',
            "{$this->auditLogApiBaseUrl}/v1/events",
            ['json' => $event]
        );
    }
}
