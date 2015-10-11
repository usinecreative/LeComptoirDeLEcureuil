<?php

namespace BlueBear\MediaBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class MediaUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options = [])
    {
        $formBuilder
            ->add('name')
            ->add('file', 'file');
    }

    public function getName()
    {
        return 'media_upload';
    }
}
