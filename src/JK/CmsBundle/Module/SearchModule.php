<?php

namespace JK\CmsBundle\Module;

use JK\CmsBundle\Form\Type\SearchType;
use Symfony\Component\Form\FormFactoryInterface;
use Twig_Environment;

class SearchModule implements ModuleInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * SearchModule constructor.
     *
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * Return the Module name.
     *
     * @return string
     */
    public function getName()
    {
        return 'search';
    }

    /**
     * @param Twig_Environment $twig
     * @param array            $context
     *
     * @return string
     */
    public function render(Twig_Environment $twig, array $context = [])
    {
        $form = $this
            ->formFactory
            ->create(SearchType::class)
        ;

        return $twig->render('@JKCms/Search/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return array
     */
    public function getZones()
    {
        return [
            'navbar',
        ];
    }
}
