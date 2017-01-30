<?php

namespace BlueBear\CmsBundle\Form\Type;

use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Form\Type\JQueryUploadType;
use JK\CmsBundle\Form\Type\TagCollectionEmbedType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
                'class' => 'BlueBear\CmsBundle\Entity\Category',
                'label' => 'cms.article.category',
                'attr' => [
                    'data-help' => 'cms.article.category_help',
                ],
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'rows' => 15,
                    'class' => 'tinymce',
                    'data-theme' => 'advanced',
                    'data-help' => 'cms.article.content_help',
                ],
                'label' => 'cms.article.content',
                'required' => false,
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
            ])
            ->add('author', EntityType::class, [
                'label' => 'cms.article.author',
                'attr' => [
                    'data-help' => 'cms.article.author_help',
                ],
                'empty_data' => false,
                'class' => 'BlueBear\CmsBundle\Entity\User',
            ])
            ->add('isCommentable', CheckboxType::class, [
                'label' => 'cms.article.isCommentable',
                'required' => false,
                'attr' => [
                    'data-help' => 'cms.article.isCommentable_help',
                ],
            ])
            ->add('createdAt', DateType::class, [
                'label' => 'cms.article.createdAt',
                'attr' => [
                    'data-help' => 'cms.article.createdAt_help',
                ],
                'disabled' => true,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ])
            ->add('updatedAt', DateType::class, [
                'label' => 'cms.article.updatedAt',
                'attr' => [
                    'data-help' => 'cms.article.updatedAt_help',
                ],
                'disabled' => true,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
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
