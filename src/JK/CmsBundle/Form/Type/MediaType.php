<?php

namespace JK\CmsBundle\Form\Type;

use JK\CmsBundle\Form\Transformer\MediaTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class MediaType extends AbstractType
{
    /**
     * @var MediaTransformer
     */
    private $mediaTransformer;
    
    /**
     * MediaType constructor.
     *
     * @param MediaTransformer $mediaTransformer
     */
    public function __construct(MediaTransformer $mediaTransformer)
    {
        $this->mediaTransformer = $mediaTransformer;
    }
    
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('name', TextType::class, [
                'property_path' => 'name',
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'cms.media.category_thumbnail' => 'category_thumbnail',
                    'cms.media.article_thumbnail' => 'article_thumbnail',
                ],
                'attr' => [
                    'data-help' => 'cms.media.type_help',
                ]
            ])
            ->add('filename', FileType::class, [
                'required' => false,
            ])
        ;
        
        $builder
            ->addModelTransformer($this->mediaTransformer)
            ->addEventListener(FormEvents::PRE_SET_DATA, function(FormEvent $event) {
                $media = $event->getData();
    
                if (null !== $media->getFileName()) {
                    $this
                        ->mediaTransformer
                        ->setOriginalFileName($media->getFileName());
                }
            })
        ;
    }
}
