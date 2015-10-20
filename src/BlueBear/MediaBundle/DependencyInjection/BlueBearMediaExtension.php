<?php

namespace BlueBear\MediaBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BlueBearMediaExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (!array_key_exists('resources_path', $config)) {
            // default value %kernel.root_dir%/../resources
            $config['resources_path'] = $container->getParameter('kernel.root_dir') . '/../resources';
        }
        $container->setParameter('bluebear.media.resources_path', $config['resources_path']);
    }

    public function getAlias()
    {
        return 'bluebear_media';
    }
}
