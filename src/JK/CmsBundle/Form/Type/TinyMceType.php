<?php

namespace JK\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TinyMceType extends AbstractType
{
    /**
     * @return string
     */
    public function getParent()
    {
        return TextareaType::class;
    }

    /**
     * Add the required javascript to make tinymce working.
     *
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['scripts'] = [
            'footer' => [
                // add the sticky js to handle the tinymce toolbars when scrolling and improve UX
                '/bundles/jkcms/js/jquery.sticky.js',
                // tinymce configuration. The array key "tinymce" does not matter here, he can be anything else, as we
                // provide and template, this template will be used to render the script
                'tinymce' => [
                    'template' => '@JKCms/Article/form.js.html.twig',
                    'context' => [
                        'id' => $options['tinymce_selector'],
                        'contentCss' => $options['tinymce_content_css'],
                        'plugins' => $options['tinymce_plugins'],
                        'toolbar' => $options['tinymce_toolbar'],
                    ],
                ],
            ],
        ];
        // we should define a real unique id (afaik, Symfony form factory does not handle yet)
        $view->vars['id'] = $options['tinymce_selector'];
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'tinymce_selector' => uniqid('tinymce-'),
                'tinymce_content_css' => 'bundles/jkcms/css/tinymce.css',
                'tinymce_plugins' => [
                    'advlist', 'autolink', 'autoresize', 'lists', 'link', 'image', 'charmap', 'print', 'preview',
                    'hr', 'anchor', 'pagebreak',
                    'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen',
                    'insertdatetime', 'media', 'nonbreaking', 'save', 'table', 'directionality',
                    'emoticons', 'template', 'paste', 'textcolor', 'colorpicker', 'textpattern', 'imagetools',
                ],
                'tinymce_toolbar' => 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter '
                    .'alignright alignjustify | bullist numlist outdent indent | link image toolbar2: print preview '
                    .'media | forecolor backcolor emoticons code | add_gallery add_gallery',
            ])
            ->setAllowedTypes('tinymce_plugins', 'array')
        ;
    }
}
