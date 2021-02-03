<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\Event;

use JsonSerializable;
use Symfony\Component\Uid\Uuid;

final class AggregateUuid implements JsonSerializable
{
    private Uuid $uuid;

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function jsonSerialize(): string
    {
        return $this->uuid->jsonSerialize();
    }

    public function __toString(): string
    {
        return $this->uuid->jsonSerialize();
    }
}
