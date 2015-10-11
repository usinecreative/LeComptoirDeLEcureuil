<?php

namespace BlueBear\CmsBundle\Form\Type;

use BlueBear\CmsBundle\Entity\Content;
use BlueBear\CmsBundle\Factory\ContentTypeFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug', 'text', [
                'read_only' => true
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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'BlueBear\CmsBundle\Entity\Category'
        ]);
    }
}
