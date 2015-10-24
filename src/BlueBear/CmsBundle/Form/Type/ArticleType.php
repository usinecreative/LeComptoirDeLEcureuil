<?php

namespace BlueBear\CmsBundle\Form\Type;

use BlueBear\CmsBundle\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //
        //->add('thumbnail', 'media_upload')
//            ->add('content', 'ckeditor', [
//                'config' => [
//                    'height' => '800px'
//                ]
//            ])
        $builder
            ->add('title', 'text')
            ->add('category')
            ->add('canonical', 'text', [
                'read_only' => true
            ])
            ->add('content', 'textarea', [
                'attr' => [
                    'class' => 'tinymce'
                ]
            ])
            ->add('publicationStatus', 'choice', [
                'choices' => [
                    Article::PUBLICATION_STATUS_DRAFT => 'bluebear.cms.publication.draft',
                    Article::PUBLICATION_STATUS_VALIDATION => 'bluebear.cms.publication.validation',
                    Article::PUBLICATION_STATUS_PUBLISHED => 'bluebear.cms.publication.published',
                ]
            ])
            ->add('publicationDate', 'datetime_picker', [
                'required' => false
            ])
            ->add('author')
            ->add('isCommentable', 'checkbox', [
                'required' => false
            ])
            ->add('createdAt', 'date', [
                'read_only' => true,
                'disabled' => true,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
            ])
            ->add('updatedAt', 'date', [
                'read_only' => true,
                'disabled' => true,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'BlueBear\CmsBundle\Entity\Article'
        ]);
    }

    public function getName()
    {
        return 'article';
    }
}
