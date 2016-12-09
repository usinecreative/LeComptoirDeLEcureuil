<?php

namespace JK\CmsBundle\Assets;

use Exception;
use JK\CmsBundle\Entity\MediaInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\Routing\RouterInterface;

class AssetsHelper
{
    /**
     * @var array
     */
    private $assetsMapping;
    
    /**
     * @var RouterInterface
     */
    private $router;
    
    /**
     * @var string
     */
    private $environment;
    
    /**
     * @var CacheManager
     */
    private $assetsManager;
    
    /**
     * AssetsHelper constructor.
     *
     * @param string $environment
     * @param array $assetsMapping
     * @param RouterInterface $router
     * @param CacheManager $assetsManager
     */
    public function __construct(
        $environment = 'dev',
        array $assetsMapping = [],
        RouterInterface $router,
        CacheManager $assetsManager
    ) {
        $this->assetsMapping = $assetsMapping;
        
        if ([] === $this->assetsMapping) {
            $this->assetsMapping = [
                'gallery' => '/uploads/gallery'
            ];
        }
        $this->router = $router;
        $this->environment = $environment;
        $this->assetsManager = $assetsManager;
    }
    
    public function getMediaPath(MediaInterface $media, $absolute = true, $cache = true, $mediaFilter = null)
    {
        if (!array_key_exists($media->getType(), $this->assetsMapping)) {
            throw new Exception('No assets mapping found for media type '.$media->getType());
        }
    
        if (null === $mediaFilter) {
            $mediaFilter = $media->getType();
        }
        
        $relativePath = sprintf(
            '%s/%s',
            $this->assetsMapping[$media->getType()],
            $media->getFileName()
        );
        $path = $relativePath;
    
        if ($absolute) {
            $context = $this
                ->router
                ->getContext();
            $path = $context->getScheme().'://'.$context->getHost().$path;
    
            $path = str_replace('app_'.$this->environment.'.php', '', $path);
        }
    
        if ($cache) {
            $path = $this
                ->assetsManager
                ->getBrowserPath($relativePath, $mediaFilter);
        }
    
        return $path;
    }
    
    public function getMediaDirectory($mappingName)
    {
        if (!array_key_exists($mappingName, $this->assetsMapping)) {
            throw new Exception('No assets mapping found for media type '.$mappingName);
        }
    
        return $this->assetsMapping[$mappingName];
    }
}
