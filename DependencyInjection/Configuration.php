<?php

namespace Octante\NatsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('octante_nats');

        $rootNode
            ->children()
                ->arrayNode('connections')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('host')->defaultValue('localhost')->end()
                            ->integerNode('port')->defaultValue(4222)->end()
                            ->scalarNode('user')->end()
                            ->scalarNode('password')->end()
                            ->booleanNode('verbose')->defaultFalse()->end()
                            ->booleanNode('reconnect')->defaultTrue()->end()
                            ->scalarNode('version')->end()
                            ->booleanNode('pedantic')->defaultFalse()->end()
                            ->scalarNode('lang')->defaultValue('php')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
