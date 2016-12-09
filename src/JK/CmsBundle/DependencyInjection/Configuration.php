<?php

namespace JK\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jk_cms');
        
        $rootNode
            ->children()
            ->arrayNode('assets')
                ->children()
                ->arrayNode('mapping')
                    ->defaultValue([
                        'gallery' => '/uploads/gallery',
                        'article_thumbnail' => '/uploads/articles/thumbnails',
                        'category_thumbnail' => '/uploads/categories/thumbnails',
                    ])
                    ->prototype('scalar')
                ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
