<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\Event;

final class SourceIp implements \JsonSerializable
{
    private string $sourceIp;

    public function __construct(string $sourceIp)
    {
        $this->sourceIp = $sourceIp;
    }

    public function getSourceIp(): string
    {
        return $this->sourceIp;
    }

    public function jsonSerialize(): string
    {
        return $this->sourceIp;
    }

    public function __toString(): string
    {
        return $this->sourceIp;
    }
}
