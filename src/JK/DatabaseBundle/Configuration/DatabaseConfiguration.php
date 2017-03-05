<?php

namespace JK\DatabaseBundle\Configuration;

use LAG\AdminBundle\Configuration\Configuration;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatabaseConfiguration extends Configuration
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'host' => null,
                'port' => null,
            ])
            ->setRequired([
                'name',
                'user',
                'password',
            ])
            ->setAllowedTypes('host', 'string')
            ->setAllowedTypes('name', 'string')
            ->setAllowedTypes('host', 'string')
            ->setAllowedTypes('user', 'string')
            ->setAllowedTypes('password', 'string')
        ;
    }
}
