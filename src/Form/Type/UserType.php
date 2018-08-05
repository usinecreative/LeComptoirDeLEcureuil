<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User $user */
        $user = $options['data'];

        $builder->add('username', TextType::class, [
            'label' => 'form.username',
        ]);
        $builder->add('email', TextType::class, [
            'label' => 'form.email',
        ]);
        if (!$user->getId()) {
            $builder->add('plainPassword', RepeatedType::class, [
                'type' => 'password',
                'first_options' => [
                    'label' => 'form.password',
                ],
                'second_options' => [
                    'label' => 'form.password_confirmation',
                ],
            ]);
        }
        $builder->add('roles', ChoiceType::class, [
            'choices' => [
                'ROLE_ADMIN' => 'bluebear.cms.administrator',
                'ROLE_CONTRIBUTOR' => 'bluebear.cms.contributor',
            ],
            'expanded' => true,
            'multiple' => true,
            'translation_domain' => 'messages',
        ]);
        $builder->add('enabled', CheckboxType::class, [
            'required' => false,
            'label' => 'bluebear.cms.enabled',
            'translation_domain' => 'messages',
        ]);
    }
}
