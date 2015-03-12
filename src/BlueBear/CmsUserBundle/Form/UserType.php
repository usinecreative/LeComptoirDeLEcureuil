<?php

namespace BlueBear\CmsUserBundle\Form;

use Symfony\Component\Form\AbstractType;

class UserType extends AbstractType
{
    public function getName()
    {
        return 'user';
    }
}