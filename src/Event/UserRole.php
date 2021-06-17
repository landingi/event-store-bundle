<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\Event;

use JsonSerializable;

final class UserRole implements JsonSerializable
{
    private string $role;

    public function __construct(string $role)
    {
        $this->role = $role;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function jsonSerialize(): string
    {
        return $this->role;
    }

    public function __toString(): string
    {
        return $this->role;
    }
}
