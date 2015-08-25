<?php

namespace BlueBear\CmsBundle\Form\Type;

use BlueBear\CmsBundle\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('category')
            ->add('canonical', 'text', [
                'read_only' => true
            ])
            ->add('content', 'ckeditor', [
                'config' => [
                    'height' => '800px'
                ]
            ])
            ->add('publicationStatus', 'choice', [
                'choices' => [
                    Article::PUBLICATION_STATUS_DRAFT => 'bluebear.cms.publication.draft',
                    Article::PUBLICATION_STATUS_VALIDATION => 'bluebear.cms.publication.validation',
                    Article::PUBLICATION_STATUS_PUBLISHED => 'bluebear.cms.publication.published',
                ]
            ])
            ->add('publicationDate', 'datetime')
            ->add('author', null, [
                'required' => true
            ])
            ->add('isCommentable', 'checkbox')
            ->add('createdAt', 'date', [
                'read_only' => true,
                'disabled' => true,
                'widget' => 'single_text'
            ])
            ->add('updatedAt', 'date', [
                'read_only' => true,
                'disabled' => true,
                'widget' => 'single_text'
            ]);
    }

    public function getName()
    {
        return 'article';
    }
}
