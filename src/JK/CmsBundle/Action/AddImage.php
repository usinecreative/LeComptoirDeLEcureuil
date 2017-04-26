<?php

namespace JK\CmsBundle\Action;

use JK\CmsBundle\Form\Type\AddImageType;
use JK\CmsBundle\Repository\MediaRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class AddImage
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    
    /**
     * @var Twig_Environment
     */
    private $twig;
    
    /**
     * @var MediaRepository
     */
    private $mediaRepository;
    
    /**
     * AddImage constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param Twig_Environment     $twig
     * @param MediaRepository      $mediaRepository
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Twig_Environment $twig,
        MediaRepository $mediaRepository
    ) {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->mediaRepository = $mediaRepository;
    }
    
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $form = $this
            ->formFactory
            ->create(AddImageType::class)
        ;
        $medias = $this
            ->mediaRepository
            ->findAll()
        ;
    
        $content = $this
            ->twig
            ->render('@JKCms/Article/addImage.form.hml.twig', [
                'form' => $form->createView(),
                'mediaList' => $medias,
            ])
        ;
    
        return new Response($content);
    }
}
