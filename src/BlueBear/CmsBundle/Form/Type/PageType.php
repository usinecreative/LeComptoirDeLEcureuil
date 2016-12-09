<?php

namespace BlueBear\CmsBundle\Form\Type;

use JK\CmsBundle\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'cms.page.edit.title',
                'attr' => [
                    'data-help' => 'cms.page.edit.title_help'
                ]
            ])
            ->add('slug', TextType::class, [
                'label' => 'cms.page.edit.slug',
                'attr' => [
                    'data-help' => 'cms.page.edit.slug_help'
                ]
            ])
            ->add('publicationStatus', ChoiceType::class, [
                'label' => 'cms.page.edit.publication_status',
                'choices' => [
                    'cms.publication.draft' => Article::PUBLICATION_STATUS_DRAFT,
                    'cms.publication.waiting_validation' => Article::PUBLICATION_STATUS_VALIDATION,
                    'cms.publication.published' => Article::PUBLICATION_STATUS_PUBLISHED,
                ]
            ])
            ->add('publicationDate', DateTimeType::class)
            ->add('content', TextareaType::class, [
                'required' => false,
                'label' => 'cms.page.edit.content',
                'attr' => [
                    'class' => 'tinymce',
                    'data-help' => 'cms.page.edit.content_help'
                ]
            ])
        ;
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'page';
    }
}
