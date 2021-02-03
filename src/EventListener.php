<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle;

interface EventListener
{
    public function onEvent(Event $event): void;
}
