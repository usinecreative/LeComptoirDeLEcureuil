<?php

namespace BlueBear\CmsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class BlueBearCmsExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (!array_key_exists('content', $config)) {
            throw new \Exception('You should have a "content" section in your cms configuration');
        } else {
            // do not provide empty behaviors configuration
            if (array_key_exists('behaviors', $config['content']) and !count($config['content']['behaviors'])) {
                unset($config['content']['behaviors']);
            }
        }
        $container->setParameter('bluebear.cms.content', $config['content']);
    }
}
