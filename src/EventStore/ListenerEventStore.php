<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventStore;

use Landingi\EventStoreBundle\Event;
use Landingi\EventStoreBundle\EventListener;
use Landingi\EventStoreBundle\EventStore;

final class ListenerEventStore implements EventStore
{
    private EventStore $store;

    /**
     * @var EventListener[]
     */
    private array $listeners;

    public function __construct(EventStore $store)
    {
        $this->store = $store;
    }

    public function addListener(EventListener $listener): void
    {
        $this->listeners[] = $listener;
    }

    public function store(Event $event): void
    {
        $this->store->store($event);

        foreach ($this->listeners as $listener) {
            $listener->onEvent($event);
        }
    }
}
