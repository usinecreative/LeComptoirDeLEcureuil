<?php

namespace App\JK\SmokerBundle;

use App\JK\SmokerBundle\DependencyInjection\JKSmokerExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class JKSmokerBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new JKSmokerExtension();
    }
}
