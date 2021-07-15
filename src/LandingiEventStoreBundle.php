<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle;

use Landingi\EventStoreBundle\DependencyInjection\LandingiEventStoreListenerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class LandingiEventStoreBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new LandingiEventStoreListenerPass());
    }
}
