<?php

namespace LeComptoirDeLEcureuil\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LeComptoirDeLEcureuilUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
