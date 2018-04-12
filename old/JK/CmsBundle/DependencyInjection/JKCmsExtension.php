<?php

namespace JK\CmsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class JKCmsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('forms.yml');
        $loader->load('transformers.yml');
        $loader->load('modules.yml');
        $loader->load('repositories.yml');

        if (!array_key_exists('assets', $config)) {
            throw new InvalidConfigurationException('"assets" key should be present in configuration');
        }
        $container->setParameter('cms.assets.mapping', $config['assets']['mapping']);
        $container->setParameter('cms.assets.upload_directory', $config['assets']['upload_directory']);
    }
}
