<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class LandingiEventStoreExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('services.xml');
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if ($config['auditlog']['enabled']) {
            $container->setParameter('landingi_event_store.auditlog.endpoint', $config['auditlog']['endpoint']);
            $container->setParameter('landingi_event_store.auditlog.client', $config['auditlog']['client']);
            $container->setParameter('landingi_event_store.auditlog.strict_mode', $config['auditlog']['strict_mode']);
        }

        $container->setParameter('landingi_event_store.event_store.connection', $config['event_store']['connection']);
    }
}
