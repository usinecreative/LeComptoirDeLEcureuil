<?php

namespace App\JK\SmokerBundle\DependencyInjection\CompilerPass;

use App\JK\SmokerBundle\Url\Response\Handler\ResponseHandlerInterface;
use App\JK\SmokerBundle\Url\Response\Registry\ResponseHandlerRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ResponseHandlerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $registry = $container->getDefinition(ResponseHandlerRegistry::class);

        foreach ($container->getDefinitions() as $serviceId => $definition) {
            $implements = class_implements($definition->getClass());

            if (in_array(ResponseHandlerInterface::class, $implements)) {
                $registry->addMethodCall('add', [
                    $serviceId,
                    new Reference($serviceId),
                ]);
            }
        }
    }
}
