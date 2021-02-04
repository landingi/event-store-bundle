<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle;

interface EventStore
{
    public function store(Event $event): void;
}
