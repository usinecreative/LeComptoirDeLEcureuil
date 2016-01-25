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
                'label' => 'lecomptoir.contact.first_name'
            ])
            ->add('lastName', 'text', [
                'label' => 'lecomptoir.contact.last_name'
            ])
            ->add('email', 'email')
            // anti spam field
            ->add('url', 'text', [
                'required' => false
            ])
            ->add('message', 'textarea', [
                'label' => 'lecomptoir.contact.message'
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
