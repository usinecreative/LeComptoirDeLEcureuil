<?php

namespace JK\CmsBundle\Form\Type;

use JK\CmsBundle\Form\Constraint\AddImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddImageType extends AbstractType
{
    const UPLOAD_FROM_URL = 'upload_from_url';
    const UPLOAD_FROM_COMPUTER = 'upload_from_computer';
    const CHOOSE_FROM_COLLECTION = 'choose_from_collection';
    
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('uploadType', ChoiceType::class, [
                'choices' => [
                    'cms.media.upload_from_url' => self::UPLOAD_FROM_URL,
                    'cms.media.upload_from_computer' => self::UPLOAD_FROM_COMPUTER,
                    'cms.media.choose_from_collection' => self::CHOOSE_FROM_COLLECTION,
                ],
                'expanded' => true,
                'attr' => [
                    'class' => 'media-choice',
                ],
            ])
            ->add('url', UrlType::class, [
                'required' => false,
                'attr' => [
                    'class' => self::UPLOAD_FROM_URL,
                ],
            ])
            ->add('upload', FileType::class, [
                'required' => false,
                'attr' => [
                    'class' => self::UPLOAD_FROM_COMPUTER,
                ],
            ])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'constraints' => [
                new AddImage(),
            ],
        ]);
    }
}
