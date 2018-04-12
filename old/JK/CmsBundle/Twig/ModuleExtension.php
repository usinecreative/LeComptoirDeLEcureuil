<?php

namespace JK\CmsBundle\Twig;

use JK\CmsBundle\Module\ModuleRenderer;
use Twig_Extension;
use Twig_SimpleFunction;

class ModuleExtension extends Twig_Extension
{
    /**
     * @var ModuleRenderer
     */
    private $moduleRenderer;

    /**
     * ModuleExtension constructor.
     *
     * @param ModuleRenderer $moduleRenderer
     */
    public function __construct(ModuleRenderer $moduleRenderer)
    {
        $this->moduleRenderer = $moduleRenderer;
    }

    /**
     * Return the Twig function mapping.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('cms_render_module', [$this, 'cmsRenderModule']),
        ];
    }

    /**
     * @param string $name Module name
     *
     * @return string
     */
    public function cmsRenderModule($name)
    {
        return $this
            ->moduleRenderer
            ->render($name)
        ;
    }
}
