<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'cms.partner.name'
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'rows' => 10,
                    'class' => 'tinymce',
                    'data-theme' => 'advanced'
                ],
                'label' => 'cms.partner.description',
                'required' => false,
            ])
            ->add('baseline')
            ->add('website', UrlType::class, [
                'label' => 'cms.partner.website',
                'required' => false
            ])
            ->add('twitter', UrlType::class, [
                'label' => 'cms.partner.twitter',
                'required' => false
            ])
            ->add('facebook', UrlType::class, [
                'label' => 'cms.partner.facebook',
                'required' => false
            ])
            ->add('instagram', UrlType::class, [
                'label' => 'cms.partner.instagram',
                'required' => false
            ])
        ;
    }
}
