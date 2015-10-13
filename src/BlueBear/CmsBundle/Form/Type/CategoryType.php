<?php

namespace BlueBear\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug', 'text', [
                'read_only' => true
            ])
            ->add('description', 'textarea', [
                'required' => false
            ])
            ->add('displayInHomepage', 'checkbox', [
                'required' => false
            ])
            ->add('updatedAt', 'datetime', [
                'widget' => 'single_text',
                'read_only' => true
            ]);
    }

    public function getName()
    {
        return 'category';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'BlueBear\CmsBundle\Entity\Category'
        ]);
    }
}
