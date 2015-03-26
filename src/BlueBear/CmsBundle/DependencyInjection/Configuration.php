<?php

namespace BlueBear\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('blue_bear_cms');

        $rootNode
            ->children()
                ->arrayNode('content')
                    ->children()
                        ->arrayNode('behaviors')
                            ->prototype('array')
                            ->end()
                        ->end()
                        ->arrayNode('types')
                            ->prototype('array')
                                ->children()
                                    ->arrayNode('fields')
                                        ->prototype('scalar')
                                        ->end()
                                    ->end()
                                    ->arrayNode('behaviors')
                                        ->prototype('scalar')
                                        ->end()
                                    ->end()
                                    ->scalarNode('parent')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}
