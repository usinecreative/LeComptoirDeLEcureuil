<?php

namespace BlueBear\CmsBundle\Form\Type;

use App\Entity\Category;
use JK\CmsBundle\Form\Transformer\MediaUploadTransformer;
use JK\CmsBundle\Form\Type\JQueryUploadType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Category edit form.
 */
class CategoryType extends AbstractType
{
    /**
     * @var MediaUploadTransformer
     */
    protected $MediaUploadTransformer;

    /**
     * CategoryType constructor.
     *
     * @param MediaUploadTransformer $MediaUploadTransformer
     */
    public function __construct(MediaUploadTransformer $MediaUploadTransformer)
    {
        $this->MediaUploadTransformer = $MediaUploadTransformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'data-help' => 'cms.category.name_help',
                ],
            ])
            ->add('slug', TextType::class, [
                'disabled' => true,
                'attr' => [
                    'read-only' => true,
                    'data-help' => 'cms.category.slug_help',
                ],
            ])
            ->add('thumbnail', JQueryUploadType::class, [
                'end_point' => 'category_thumbnail',
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'data-help' => 'cms.category.description_help',
                ],
            ])
            ->add('displayInHomepage', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'data-help' => 'cms.category.display_in_homepage_help',
                ],
            ])
            ->add('updatedAt', DateType::class, [
                'widget' => 'single_text',
                'disabled' => true,
                'attr' => [
                    'read-only' => true,
                    'data-help' => 'cms.category.updated_at_help',
                ],
            ])
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'category';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
