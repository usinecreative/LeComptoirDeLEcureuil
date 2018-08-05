<?php

namespace App\Form\Type;

use App\Entity\Article;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Article form type.
 */
class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'cms.article.title',
                'attr' => [
                    'data-help' => 'cms.article.title_help',
                    'contenteditable' => 'true',
                    'spellcheck' => 'true',
                ],
            ])
            ->add('canonical', UrlType::class, [
                'label' => 'cms.article.canonical',
                'attr' => [
                    'data-help' => 'cms.article.canonical_help',
                ],
                'disabled' => true,
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\Category',
                'label' => 'cms.article.category',
                'attr' => [
                    'data-help' => 'cms.article.category_help',
                ],
            ])
            ->add('thumbnail', JQueryUploadType::class, [
                'end_point' => 'article_thumbnail',
            ])
            ->add('publicationStatus', ChoiceType::class, [
                'label' => 'cms.article.publicationStatus',
                'attr' => [
                    'data-help' => 'cms.article.publicationStatus_help',
                ],
                'choices' => [
                    'lag.cms.publication.draft' => Article::PUBLICATION_STATUS_DRAFT,
                    'lag.cms.publication.validation' => Article::PUBLICATION_STATUS_VALIDATION,
                    'lag.cms.publication.published' => Article::PUBLICATION_STATUS_PUBLISHED,
                ],
            ])
            ->add('publicationDate', DateTimeType::class, [
                'label' => 'cms.article.publicationDate',
                'attr' => [
                    'data-help' => 'cms.article.publicationDate_help',
                ],
                'required' => false,
            ])
            ->add('tags', TagCollectionEmbedType::class, [
                'required' => false,
                'compound' => false,
                'attr' => [
                    'contenteditable' => 'true',
                    'spellcheck' => 'true',
                ],
            ])
            ->add('author', EntityType::class, [
                'label' => 'cms.article.author',
                'attr' => [
                    'data-help' => 'cms.article.author_help',
                ],
                'empty_data' => false,
                'class' => 'App\Entity\User',
            ])
            ->add('isCommentable', CheckboxType::class, [
                'label' => 'cms.article.isCommentable',
                'required' => false,
                'attr' => [
                    'data-help' => 'cms.article.isCommentable_help',
                ],
            ])
            ->add('content', TinyMceType::class, [
                'attr' => [
                    'rows' => 15,
                    'class' => 'tinymce sticky-menu affick affick-top',
                    'data-theme' => 'advanced',
                    'data-help' => 'cms.article.content_help',
                    'contenteditable' => 'true',
                    'spellcheck' => 'true',
                ],
                'label' => 'cms.article.content',
                'required' => false,
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $selector = uniqid('tinymce-');

        $resolver->setDefaults([
            'data_class' => Article::class,
            'tinymce_selector' => $selector,
            'attr' => [
                'id' => $selector,
            ],
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'article';
    }
}
