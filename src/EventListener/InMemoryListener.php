<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\EventListener;

use Landingi\EventStoreBundle\Event;
use Landingi\EventStoreBundle\EventListener;

final class InMemoryListener implements EventListener
{
    private array $events;

    public function __construct()
    {
        $this->events = [];
    }

    public function onEvent(Event $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return Event[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
