<?php

namespace BlueBear\MediaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options = [])
    {
        $formBuilder
            ->add('name', 'text', [
                'required' => false
            ])
            ->add('file', 'file', [
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'BlueBear\MediaBundle\Entity\Media'
        ]);
    }

    public function getName()
    {
        return 'media_upload';
    }
}
