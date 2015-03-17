<?php

namespace BlueBear\CmsUserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username');
        $builder->add('email');
    }

    public function getName()
    {
        return 'user';
    }
}