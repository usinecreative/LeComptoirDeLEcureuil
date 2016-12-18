<?php

namespace JK\CmsBundle\Form\Type;

use JK\CmsBundle\Form\Transformer\MediaUploadTransformer;
use Oneup\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JQueryUploadType extends AbstractType
{
    /**
     * @var UploaderHelper
     */
    protected $uploaderHelper;
    
    /**
     * @var MediaUploadTransformer
     */
    protected $MediaUploadTransformer;
    
    /**
     * JQueryUploadType constructor.
     *
     * @param UploaderHelper $uploaderHelper
     * @param MediaUploadTransformer $MediaUploadTransformer
     */
    public function __construct(UploaderHelper $uploaderHelper, MediaUploadTransformer $MediaUploadTransformer)
    {
        $this->uploaderHelper = $uploaderHelper;
        $this->MediaUploadTransformer = $MediaUploadTransformer;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('upload', FileType::class, [
                'mapped' => false,
                'property_path' => 'filename',
                'attr' => [
                    'class' => 'cms-fileupload',
                    'data-url' => $this
                        ->uploaderHelper
                        ->endpoint($options['end_point']),
                    'data-target' => '.'.$options['media_id_class'],
                ]
            ])
            ->add('id', HiddenType::class, [
                'attr' => [
                    'class' => $options['media_id_class'],
                ],
            ])
        ;
        $builder->addModelTransformer($this->MediaUploadTransformer);
    }
    
    /**
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['mediaIdClass'] = '.'.$options['media_id_class'];
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'media_id_class' => 'media-id',
                'required' => false,
                'end_point' => 'media_gallery',
            ])
        ;
    }
    
    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'jquery_upload';
    }
}
