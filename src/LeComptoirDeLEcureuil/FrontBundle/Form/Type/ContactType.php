<?php

namespace LeComptoirDeLEcureuil\FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', 'text', [
                'label' => 'lecomptoir.contact.first_name',
                'attr' => [
                    'placeholder' => 'lecomptoir.contact.first_name_placeholder'
                ]
            ])
            ->add('lastName', 'text', [
                'label' => 'lecomptoir.contact.last_name',
                'attr' => [
                    'placeholder' => 'lecomptoir.contact.last_name_placeholder'
                ]
            ])
            ->add('email', 'email', [
                'attr' => [
                    'placeholder' => 'lecomptoir.contact.email_placeholder'
                ]
            ])
            // anti spam field
            ->add('url', 'text', [
                'required' => false,
            ])
            ->add('message', 'textarea', [
                'label' => 'lecomptoir.contact.message',
                'attr' => [
                    'rows' => 10,
                    'placeholder' => 'lecomptoir.contact.first_name_placeholder'
                ]
            ])
        ;
    }

    /**
     * Return contact form name
     *
     * @return string
     */
    public function getName()
    {
        return 'contact';
    }
}
