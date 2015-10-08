<?php

namespace BlueBear\CmsImportBundle\Form\Type;

use BlueBear\CmsImportBundle\Entity\Import;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options = [])
    {
        $builder
            ->add('type', 'choice', [
                'choices' => [
                    Import::IMPORT_TYPE_WORDPRESS => 'bluebear.cms.import.wordpress'
                ]
            ])
            ->add('file', 'file', [
                //'required' => false,
            ]);
    }

    public function getName()
    {
        return 'import';
    }
}
