<?php

namespace BlueBear\CmsBundle\Form\Type;

use BlueBear\CmsBundle\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'data-help' => 'bluebear.admin.page.title_help'
                ]
            ])
            ->add('slug', TextType::class, [
                'disabled' => true,
                'attr' => [
                    'data-help' => 'bluebear.admin.page.slug_help'
                ]
            ])
            ->add('publicationStatus', ChoiceType::class, [
                'choices' => [
                    Article::PUBLICATION_STATUS_DRAFT => 'bluebear.cms.publication.draft',
                    Article::PUBLICATION_STATUS_VALIDATION => 'bluebear.cms.publication.validation',
                    Article::PUBLICATION_STATUS_PUBLISHED => 'bluebear.cms.publication.published',
                ]
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'tinymce',
                    'data-help' => 'bluebear.admin.page.title_help'
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
