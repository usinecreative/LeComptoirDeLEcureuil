<?php

namespace App\JK\CmsBundle\Form\Type;

use App\JK\CmsBundle\Form\Constraint\InsertMedia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InsertMediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                new InsertMedia(),
            ])
        ;
    }
}
