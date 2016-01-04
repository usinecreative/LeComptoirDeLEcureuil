<?php

namespace LeComptoirDeLEcureuil\FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email', 'email')
            // anti spam field
            ->add('url', 'text', [
                'required' => false
            ])
            ->add('message', 'textarea')
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
