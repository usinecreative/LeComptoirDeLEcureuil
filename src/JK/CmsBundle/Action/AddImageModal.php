<?php

namespace JK\CmsBundle\Action;

use JK\CmsBundle\Form\Type\AddImageType;
use JK\CmsBundle\Repository\MediaRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class AddImageModal
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
        $medias = $this
            ->mediaRepository
            ->findAll()
        ;
        $form = $this
            ->formFactory
            ->create(AddImageType::class)
        ;
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
    
            if (AddImageType::UPLOAD_FROM_COMPUTER === $data['uploadType']) {
                $file = $data['upload'];
                
            }
            
            
            return new JsonResponse([
                'lol' => 'test',
            ]);
        }
    
        $content = $this
            ->twig
            ->render('@JKCms/Article/addImage.modal.html.twig', [
                'form' => $form->createView(),
                'mediaList' => $medias,
            ])
        ;
    
        return new Response($content);
    }
}
