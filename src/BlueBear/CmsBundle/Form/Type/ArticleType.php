<?php

namespace BlueBear\CmsBundle\Form\Type;

use BlueBear\CmsBundle\Entity\Article;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                'disabled' => true
            ])
            ->add('content', CKEditorType::class, [
                'config_name' => 'my_config',
                'config' => [
                    'height' => '500px'
                ],
                'attr' => [
                    'rows' => 500,

                ]
            ])
            ->add('publicationStatus', ChoiceType::class, [
                'choices' => [
                    'bluebear.cms.publication.draft' => Article::PUBLICATION_STATUS_DRAFT,
                    'bluebear.cms.publication.validation' => Article::PUBLICATION_STATUS_VALIDATION,
                    'bluebear.cms.publication.published' => Article::PUBLICATION_STATUS_PUBLISHED,
                ]
            ])
            ->add('publicationDate', DateTimeType::class, [
                'required' => false
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
