<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventListener\AuditLogListener;

interface AuditLogClient
{
    public function store(AuditLogEvent $event): void;
}
