<?php

namespace JK\CmsBundle\Form\Type;

use JK\CmsBundle\Form\Transformer\MediaTransformer;
use Oneup\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JQueryUploadType extends AbstractType
{
    /**
     * @var UploaderHelper
     */
    protected $uploaderHelper;
    
    /**
     * @var MediaTransformer
     */
    protected $mediaTransformer;
    
    /**
     * JQueryUploadType constructor.
     *
     * @param UploaderHelper $uploaderHelper
     * @param MediaTransformer $mediaTransformer
     */
    public function __construct(UploaderHelper $uploaderHelper, MediaTransformer $mediaTransformer)
    {
        $this->uploaderHelper = $uploaderHelper;
        $this->mediaTransformer = $mediaTransformer;
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
                    'data-target' => $options['media_id_selector'],
                ]
            ])
            ->add('id', HiddenType::class, [
                'attr' => [
                    'class' => 'media-id',
                ]
            ])
        ;
        $builder
            ->addModelTransformer($this->mediaTransformer)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'media_id_selector' => '.media-id',
                'required' => false,
                'end_point' => 'gallery'
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
