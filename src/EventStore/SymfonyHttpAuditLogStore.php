<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventStore;

use Landingi\EventStoreBundle\Event;
use Landingi\EventStoreBundle\EventStore;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SymfonyHttpAuditLogStore implements EventStore
{
    private string $auditLogApiBaseUrl;
    private HttpClientInterface $auditLogApiHttpClient;

    public function __construct(string $auditLogApiBaseUrl, HttpClientInterface $auditLogApiHttpClient)
    {
        $this->auditLogApiBaseUrl = $auditLogApiBaseUrl;
        $this->auditLogApiHttpClient = $auditLogApiHttpClient;
    }

    public function store(Event $event): void
    {
        $this->auditLogApiHttpClient->request(
            'POST',
            "{$this->auditLogApiBaseUrl}/v1/events",
            ['json' => $event]
        );
    }
}
