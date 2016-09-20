<?php

namespace BlueBear\CmsBundle\Form\Type;

use BlueBear\CmsBundle\Entity\Article;
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
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Article form type
 */
class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('canonical', UrlType::class, [
                'disabled' => true,
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'class' => 'BlueBear\CmsBundle\Entity\Category'
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'rows' => 15,
                    'class' => 'tinymce',
                    'data-theme' => 'advanced'
                ]
            ])
            ->add('thumbnailFile', VichImageType::class, [
                'required' => false
            ])
            ->add('publicationStatus', ChoiceType::class, [
                'choices' => [
                    'lag.cms.publication.draft' => Article::PUBLICATION_STATUS_DRAFT,
                    'lag.cms.publication.validation' => Article::PUBLICATION_STATUS_VALIDATION,
                    'lag.cms.publication.published' => Article::PUBLICATION_STATUS_PUBLISHED,
                ]
            ])
            ->add('publicationDate', DateTimeType::class, [
                'required' => false,
            ])
            ->add('author', EntityType::class, [
                'empty_data' => false,
                'class' => 'BlueBear\CmsBundle\Entity\User'
            ])
            ->add('isCommentable', CheckboxType::class, [
                'required' => false
            ])
            ->add('createdAt', DateType::class, [
                'disabled' => true,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
            ])
            ->add('updatedAt', DateType::class, [
                'disabled' => true,
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'BlueBear\CmsBundle\Entity\Article'
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
