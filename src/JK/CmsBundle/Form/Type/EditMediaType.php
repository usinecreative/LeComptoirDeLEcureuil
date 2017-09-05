<?php

namespace JK\CmsBundle\Form\Type;

use JK\CmsBundle\Form\Transformer\HtmlPropertyTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;

class EditMediaType extends AbstractType
{
    const ALIGNMENT_LEFT = 'left';
    const ALIGNMENT_RIGHT = 'right';
    const ALIGNMENT_CENTER = 'center';
    const ALIGNMENT_FIT_TO_WIDTH = 'fit_to_width';
    
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('height', IntegerType::class, [
                'attr' => [
                    'class' => 'height-input',
                ],
                'constraints' => [
                    new Range([
                        'min' => 1,
                    ])
                ],
            ])
            ->add('width', IntegerType::class, [
                'attr' => [
                    'class' => 'width-input',
                ],
                'constraints' => [
                    new Range([
                        'min' => 1,
                        // TODO move into configuration (site max width)
                        'max' => 2000,
                    ])
                ]
            ])
            ->add('keep_proportion', CheckboxType::class, [
                'attr' => [
                    'class' => 'keep-proportion-checkbox',
                    'data-target-width' => '.width-input',
                    'data-target-height' => '.height-input',
                ],
                'data' => true,
                'required' => false,
            ])
            ->add('alignment', ChoiceType::class, [
                'choices' => [
                    'cms.main.align_left' => self::ALIGNMENT_LEFT,
                    'cms.main.align_right' => self::ALIGNMENT_RIGHT,
                    'cms.main.align_center' => self::ALIGNMENT_CENTER,
                    'cms.main.fit_to_width' => self::ALIGNMENT_FIT_TO_WIDTH,
                ],
                //'data' =>  self::ALIGNMENT_LEFT,
                'expanded' => true,
            ])
            ->addModelTransformer(new HtmlPropertyTransformer())
        ;
    }
}
