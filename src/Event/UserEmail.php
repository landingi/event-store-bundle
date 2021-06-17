<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\Event;

final class UserEmail
{
    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function jsonSerialize(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
