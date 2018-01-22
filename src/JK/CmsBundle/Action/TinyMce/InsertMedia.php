<?php

namespace JK\CmsBundle\Action\TinyMce;

use JK\CmsBundle\Assets\AssetsHelper;
use JK\CmsBundle\Repository\MediaRepository;
use Symfony\Component\HttpFoundation\Request;

class InsertMedia
{
    /**
     * @var AssetsHelper
     */
    private $assetsHelper;
    
    /**
     * @var MediaRepository
     */
    private $mediaRepository;
    
    /**
     * GetImage constructor.
     *
     * @param AssetsHelper    $assetsHelper
     * @param MediaRepository $mediaRepository
     */
    public function __construct(AssetsHelper $assetsHelper, MediaRepository $mediaRepository)
    {
        $this->assetsHelper = $assetsHelper;
        $this->mediaRepository = $mediaRepository;
    }
    
    public function __invoke(Request $request)
    {
        $media = $this
            ->mediaRepository
            ->find($request->get('id'))
        ;
        $content = $this
            ->assetsHelper
            ->getMediaPath();
    }
}
