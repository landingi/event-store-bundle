<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\DependencyInjection;

use Landingi\EventStoreBundle\EventDataStore\DbalEventDataStore;
use Landingi\EventStoreBundle\EventListener\AuditLogListener;
use Landingi\EventStoreBundle\EventListener\StrictAuditLogListener;
use Landingi\EventStoreBundle\EventStore\SymfonyHttpAuditLogStore;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class LandingiEventStoreListenerPass implements CompilerPassInterface
{
    private const LISTENER_TAG = 'landingi_event_store.listener';

    public function process(ContainerBuilder $container): void
    {
        $connectionParam = $container->getParameter('landingi_event_store.event_store.connection');

        if (false === is_string($connectionParam)) {
            throw new \RuntimeException('Parameter "landingi_event_store.event_store.connection" is not a string');
        }

        $connection = $container->getDefinition($connectionParam);

        if ($container->hasParameter('landingi_event_store.auditlog.endpoint')) {
            $clientParam = $container->getParameter('landingi_event_store.auditlog.client');

            if (false === is_string($clientParam)) {
                throw new \RuntimeException('Parameter "landingi_event_store.auditlog.client" is not a string');
            }

            $container->setDefinition(
                'landingi_evnet_store.auditlog.store',
                new Definition(
                    SymfonyHttpAuditLogStore::class,
                    [
                        $container->getParameter('landingi_event_store.auditlog.endpoint'),
                        $container->getDefinition($clientParam),
                    ]
                )
            );
            $container->setDefinition(
                'landingi_event_store.auditlog.event_data_store',
                new Definition(
                    DbalEventDataStore::class,
                    [$connection]
                )
            );
            $container->setDefinition(
                'landingi_event_store.auditlog.listener',
                new Definition(
                    AuditLogListener::class,
                    [
                        $container->getDefinition('landingi_event_store.auditlog.event_data_store'),
                        $container->getDefinition('landingi_evnet_store.auditlog.store'),
                    ]
                )
            )->addTag(self::LISTENER_TAG);

            if ($container->getParameter('landingi_event_store.auditlog.strict_mode')) {
                $container->setDefinition(
                    'landingi_event_store.auditlog.listener.strict_mode_decorator',
                    new Definition(StrictAuditLogListener::class)
                )
                    ->setDecoratedService('landingi_event_store.auditlog.listener')
                    ->setArgument(0, $container->getDefinition('landingi_event_store.auditlog.listener'));
            }
        }

        $container->getDefinition('landingi_event_store.store.dbal')->replaceArgument(0, $connection);
        $listenerStoreDefinition = $container->findDefinition('landingi_event_store.store.listener');

        foreach ($container->findTaggedServiceIds(self::LISTENER_TAG, true) as $id => $tags) {
            $listenerStoreDefinition->addMethodCall(
                'addListener',
                [new Reference($id)]
            );
        }
    }
}
