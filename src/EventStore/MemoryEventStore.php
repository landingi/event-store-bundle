<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventStore;

use Landingi\EventStoreBundle\Event;
use Landingi\EventStoreBundle\EventStore;

final class MemoryEventStore implements EventStore
{
    private array $events = [];

    public function store(Event $event): void
    {
        $this->events[] = $event;
    }
}
