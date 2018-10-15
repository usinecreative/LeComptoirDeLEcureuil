<?php

namespace App\JK\SmokerBundle;

use App\JK\SmokerBundle\DependencyInjection\CompilerPass\ResponseHandlerCompilerPass;
use App\JK\SmokerBundle\DependencyInjection\JKSmokerExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class JKSmokerBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new JKSmokerExtension();
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ResponseHandlerCompilerPass());
    }
}
