<?php

namespace JK\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MediaController extends Controller
{
    public function modalGalleryAction()
    {
        $mediaList = $this
            ->get('cms.media.media_repository')
            ->findAll();

        return $this->render('@JKCms/Media/modalGallery.html.twig', [
            'mediaList' => $mediaList
        ]);
    }

    public function galleryContentAction(Request $request)
    {
        $idsString = $request->get('ids', '');
        $ids = explode(',', $idsString);

        $mediaList = $this
            ->get('cms.media.media_repository')
            ->findBy([
                'id' => $ids
            ]);

        return $this->render('@JKCms/Media/galleryContent.html.twig', [
            'mediaList' => $mediaList
        ]);
    }
}
