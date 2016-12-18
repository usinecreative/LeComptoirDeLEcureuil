<?php

namespace JK\CmsBundle\Twig;

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
     * Return the Twig function mapping.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('cms_media_path', [$this, 'cmsMediaPath']),
            new Twig_SimpleFunction('cms_media_directory', [$this, 'cmsMediaDirectory']),
            new Twig_SimpleFunction('cms_media_size', [$this, 'cmsMediaSize']),
        ];
    }
    
    /**
     * Return the path to an media according to its type.
     *
     * @param MediaInterface $media
     * @param bool $absolute
     * @param bool $cache
     * @param null|string $mediaFilter
     *
     * @return string
     */
    public function cmsMediaPath(MediaInterface $media, $absolute = true, $cache = true, $mediaFilter = null)
    {
        return $this
            ->assetsHelper
            ->getMediaPath($media, $absolute, $cache, $mediaFilter);
    }
    
    /**
     * Return the media web directory according to its type and the mapping.
     *
     * @param string $mappingName
     *
     * @return string
     */
    public function cmsMediaDirectory($mappingName)
    {
        return $this
            ->assetsHelper
            ->getMediaDirectory($mappingName);
    }
    
    /**
     * Return a string representing the media size in the most readable unit.
     *
     * @param MediaInterface $media
     * @return string
     */
    public function cmsMediaSize(MediaInterface $media)
    {
        $size = $media->getSize();
        // try size in Kio
        $size = round($size / 1024, 2);
    
        if ($size >= 1000) {
            $size = round($size / 1024, 2);
    
            return $size.' Mo';
        }
    
        return $size.' Ko';
    }
}
