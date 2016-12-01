<?php

namespace JK\CmsBundle\Twig;

use Exception;
use JK\CmsBundle\Entity\MediaInterface;
use Twig_Extension;
use Twig_SimpleFunction;

class CmsExtension extends Twig_Extension
{
    /**
     * @var array
     */
    protected $assetsMapping;

    /**
     * CmsExtension constructor.
     *
     * @param array $assetsMapping
     */
    public function __construct(array $assetsMapping = [])
    {
        $this->assetsMapping = $assetsMapping;

        if ([] === $this->assetsMapping) {
            $this->assetsMapping = [
                'gallery' => '/uploads/gallery'
            ];
        }
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('cms_asset', [
                $this,
                'cmsAsset',
            ]),
        ];
    }

    /**
     * Return the path to an media according to its type.
     *
     * @param MediaInterface $media
     * @return string
     * @throws Exception
     */
    public function cmsAsset(MediaInterface $media)
    {
        if (!array_key_exists($media->getType(), $this->assetsMapping)) {
            throw new Exception('No assets mapping found for media type '.$media->getType());
        }

        return sprintf(
            '%s/%s',
            $this->assetsMapping[$media->getType()],
            $media->getFileName()
        );
    }
}
