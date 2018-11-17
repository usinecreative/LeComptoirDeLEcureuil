<?php

namespace App\JK\CmsBundle\Form\Type;

use App\JK\CmsBundle\Form\Transformer\MediaUploadTransformer;
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
    protected $mediaUploadTransformer;

    /**
     * JQueryUploadType constructor.
     *
     * @param UploaderHelper         $uploaderHelper
     * @param MediaUploadTransformer $mediaUploadTransformer
     */
    public function __construct(UploaderHelper $uploaderHelper, MediaUploadTransformer $mediaUploadTransformer)
    {
        $this->uploaderHelper = $uploaderHelper;
        $this->mediaUploadTransformer = $mediaUploadTransformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('upload', FileType::class, [
                'attr' => [
                    'class' => 'cms-fileupload',
                    'data-url' => $this
                        ->uploaderHelper
                        ->endpoint($options['end_point']),
                    'data-target' => '.'.$options['media_id_class'],
                ],
                'label' => 'cms.media.upload_from_computer',
                'mapped' => false,
                'property_path' => 'filename',
            ])
            ->add('id', HiddenType::class, [
                'attr' => [
                    'class' => $options['media_id_class'],
                ],
            ])
        ;
        $builder->addModelTransformer($this->mediaUploadTransformer);
    }

    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
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
