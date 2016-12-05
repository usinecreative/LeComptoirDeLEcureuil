<?php

namespace JK\CmsBundle\Twig;

use Exception;
use JK\CmsBundle\Assets\AssetsHelper;
use JK\CmsBundle\Entity\MediaInterface;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Add helper methods to get media path and directory.
 */
class CmsExtension extends Twig_Extension
{
    /**
     * @var AssetsHelper
     */
    private $assetsHelper;
    
    /**
     * CmsExtension constructor.
     *
     * @param AssetsHelper $assetsHelper
     */
    public function __construct(AssetsHelper $assetsHelper)
    {
        $this->assetsHelper = $assetsHelper;
    }
    
    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('cms_media_path', [$this, 'cmsMediaPath']),
            new Twig_SimpleFunction('cms_media_directory', [$this, 'cmsMediaDirectory']),
        ];
    }

    /**
     * Return the path to an media according to its type.
     *
     * @param MediaInterface $media
     * @return string
     * @throws Exception
     */
    public function cmsMediaPath(MediaInterface $media)
    {
        return $this
            ->assetsHelper
            ->getMediaPath($media);
    }
    
    /**
     * Return the media web directory according to its type and the mapping.
     *
     * @param $mappingName
     * @return mixed
     */
    public function cmsMediaDirectory($mappingName)
    {
        return $this
            ->assetsHelper
            ->getMediaDirectory($mappingName);
    }
}
