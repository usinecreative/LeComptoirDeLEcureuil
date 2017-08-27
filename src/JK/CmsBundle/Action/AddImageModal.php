<?php

namespace JK\CmsBundle\Action;

use JK\CmsBundle\Assets\Uploader\Uploader;
use JK\CmsBundle\Assets\Uploader\UploaderInterface;
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
     * @var UploaderInterface
     */
    private $uploader;
    
    /**
     * AddImage constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param Twig_Environment     $twig
     * @param MediaRepository      $mediaRepository
     * @param UploaderInterface    $uploader
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Twig_Environment $twig,
        MediaRepository $mediaRepository,
        UploaderInterface $uploader
    ) {
        $this->formFactory = $formFactory;
        $this->twig = $twig;
        $this->mediaRepository = $mediaRepository;
        $this->uploader = $uploader;
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
                $this->uploader->upload($data['upload']);
            }
            
            return new Response(null, Response::HTTP_NO_CONTENT);
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
