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
            ->arrayNode('event_store')
                ->children()
                    ->scalarNode('connection')
                        ->isRequired()
                        ->info('Connection to landingi_production DB')
                        ->example('doctrine.dbal.mysql_connection')
                        ->validate()
                        ->ifTrue(fn ($v) => !is_string($v))
                        ->thenInvalid('The "connection" parameter must be a string.')
                    ->end()
                ->end()
            ->end()
            ->end()
            ->arrayNode('auditlog')
                ->children()
                    ->booleanNode('enabled')
                        ->defaultFalse()
                    ->end()
                    ->booleanNode('strict_mode')
                        ->defaultTrue()
                    ->end()
                    ->scalarNode('endpoint')
                        ->defaultValue(null)
                        ->info('The audit-log service endpoint')
                        ->example('http://audit-log')
                        ->validate()
                            ->ifTrue(fn ($v) => !is_string($v))
                            ->thenInvalid('The "endpoint" parameter must be a string.')
                        ->end()
                    ->end()
                    ->scalarNode('client')
                        ->defaultValue(null)
                        ->info('Instance of Symfony\Contracts\HttpClient\HttpClientInterface interface')
                        ->validate()
                            ->ifTrue(fn ($v) => !is_string($v))
                            ->thenInvalid('The "client" parameter must be a string.')
                        ->end()
                    ->end()
                ->end()
            ->validate()
                ->ifTrue(fn ($v) => $v['enabled'] && !$v['endpoint'])
                ->thenInvalid('The "endpoint" parameter is required if auditlog is enabled.')
            ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
