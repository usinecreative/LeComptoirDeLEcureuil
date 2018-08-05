<?php

namespace App\Twig;

use App\Service\Assets\AssetsHelper;
use App\Service\Assets\ScriptRegistry;
use App\Entity\MediaInterface;
use LAG\AdminBundle\Configuration\ApplicationConfiguration;
use LAG\AdminBundle\Configuration\ApplicationConfigurationStorage;
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
     * @var ScriptRegistry
     */
    private $scriptRegistry;

    /**
     * @var ApplicationConfigurationStorage
     */
    private $applicationConfigurationStorage;

    /**
     * CmsExtension constructor.
     *
     * @param AssetsHelper                    $assetsHelper
     * @param ScriptRegistry                  $scriptRegistry
     * @param ApplicationConfigurationStorage $applicationConfigurationStorage
     */
    public function __construct(
        AssetsHelper $assetsHelper,
        ScriptRegistry $scriptRegistry,
        ApplicationConfigurationStorage $applicationConfigurationStorage
    ) {
        $this->assetsHelper = $assetsHelper;
        $this->scriptRegistry = $scriptRegistry;
        $this->applicationConfigurationStorage = $applicationConfigurationStorage;
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
            new Twig_SimpleFunction('cms_dump_scripts', [$this, 'cmsDumpScripts']),
            new Twig_SimpleFunction('cms_config', [$this, 'cmsConfig']),
        ];
    }

    /**
     * Return the path to an media according to its type.
     *
     * @param MediaInterface $media
     * @param bool           $absolute
     * @param bool           $cache
     * @param null|string    $mediaFilter
     *
     * @return string
     */
    public function cmsMediaPath(MediaInterface $media, $absolute = true, $cache = true, $mediaFilter = null)
    {
        return $this
            ->assetsHelper
            ->getMediaPath($media, $absolute, $cache, $mediaFilter)
        ;
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
            ->getMediaDirectory($mappingName)
        ;
    }

    /**
     * Return a string representing the media size in the most readable unit.
     *
     * @param MediaInterface $media
     *
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

    /**
     * Dump the scripts according to the location (head or footer).
     *
     * @param string $location
     *
     * @return string
     */
    public function cmsDumpScripts($location)
    {
        return $this
            ->scriptRegistry
            ->dumpScripts($location)
        ;
    }

    /**
     * Return the application configuration object from the admin bundle.
     *
     * @return ApplicationConfiguration
     */
    public function cmsConfig()
    {
        return $this->applicationConfigurationStorage->getConfiguration();
    }
}
