<?php

namespace JK\CmsBundle\Action\TinyMce;

use JK\CmsBundle\Form\Type\EditMediaType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class EditMedia
{
    /**
     * @var Twig_Environment
     */
    private $twig;
    
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    
    public function __construct(Twig_Environment $twig, FormFactoryInterface $formFactory)
    {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
    }
    
    public function __invoke(Request $request)
    {
        $attributes = $request->get('attributes', []);
        //dump($attributes);
        //die;
    
        $form = $this->formFactory->create(EditMediaType::class, $attributes);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
   
            return new JsonResponse([
                'content' => $form->getData(),
            ]);
        }
        $content = $this
            ->twig
            ->render('@JKCms/TinyMce/editMedia.modal.html.twig', [
                'form' => $form->createView(),
            ])
        ;
    
        return new Response($content);
    }
}
