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
            ->add('name', 'text', [
                'attr' => [
                    'data-help' => 'bluebear.cms.category.name_help'
                ]
            ])
            ->add('slug', 'text', [
                'read_only' => true,
                'attr' => [
                    'data-help' => 'bluebear.cms.category.slug_help'
                ]
            ])
            ->add('description', 'textarea', [
                'required' => false,
                'attr' => [
                    'data-help' => 'bluebear.cms.category.description_help'
                ]
            ])
            ->add('displayInHomepage', 'checkbox', [
                'required' => false,
                'attr' => [
                    'data-help' => 'bluebear.cms.category.display_in_homepage_help'
                ]
            ])
            ->add('updatedAt', 'datetime', [
                'widget' => 'single_text',
                'read_only' => true,
                'attr' => [
                    'data-help' => 'bluebear.cms.category.updated_at_help'
                ]
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
