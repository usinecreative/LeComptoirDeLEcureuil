<?php

namespace JK\CmsBundle\Action\Media;

use JK\CmsBundle\Repository\MediaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class Gallery
{
    /**
     * @var MediaRepository
     */
    private $mediaRepository;
    
    /**
     * @var Twig_Environment
     */
    private $twig;
    
    public function __construct(MediaRepository $mediaRepository, Twig_Environment $twig)
    {
        $this->mediaRepository = $mediaRepository;
        $this->twig = $twig;
    }
    
    public function __invoke(Request $request)
    {
        $pager = $this
            ->mediaRepository
            ->findPagination((int)$request->get('page', 1))
        ;
        $content = $this
            ->twig
            ->render('@JKCms/Media/gallery.html.twig', [
                'pager' => $pager,
            ])
        ;
    
        return new Response($content);
    }
}
