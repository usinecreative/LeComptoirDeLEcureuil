<?php

namespace BlueBear\CmsBundle\Form\Type;


use BlueBear\CmsBundle\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder
            ->add('title', 'text', [
                'attr' => [
                    'data-help' => 'bluebear.admin.page.title_help'
                ]
            ])
            ->add('slug', 'text', [
                'read_only' => true,
                'attr' => [
                    'data-help' => 'bluebear.admin.page.slug_help'
                ]
            ])
            ->add('publicationStatus', 'choice', [
                'choices' => [
                    Article::PUBLICATION_STATUS_DRAFT => 'bluebear.cms.publication.draft',
                    Article::PUBLICATION_STATUS_VALIDATION => 'bluebear.cms.publication.validation',
                    Article::PUBLICATION_STATUS_PUBLISHED => 'bluebear.cms.publication.published',
                ]
            ])
            ->add('content', 'textarea', [
                'attr' => [
                    'class' => 'tinymce',
                    'data-help' => 'bluebear.admin.page.title_help'
                ]
            ])


        ;
    }

    public function getName()
    {
        return 'page';
    }
}
