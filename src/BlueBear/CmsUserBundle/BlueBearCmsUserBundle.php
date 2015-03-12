<?php

namespace BlueBear\CmsUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BlueBearCmsUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
