<?php
declare(strict_types=1);

namespace Landingi\EventStoreBundle\DependencyInjection;

use RuntimeException;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('landingi_event_store');
        $rootNode = $treeBuilder->getRootNode();

        if (!$rootNode instanceof ArrayNodeDefinition) {
            throw new RuntimeException('Invalid configuration in landingi_event_store.yaml');
        }

        $rootNode->children()
            ->arrayNode('auditlog')
                ->children()
                    ->booleanNode('enabled')
                        ->defaultValue(true)
                    ->end()
                    ->scalarNode('endpoint')->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
