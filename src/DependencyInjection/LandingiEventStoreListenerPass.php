<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class LandingiEventStoreListenerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
    }
}
