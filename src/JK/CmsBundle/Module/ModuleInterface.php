<?php

namespace JK\CmsBundle\Module;

use Twig_Environment;

interface ModuleInterface
{
    /**
     * Return the Module name.
     *
     * @return string
     */
    public function getName();
    
    /**
     * @param Twig_Environment $twig
     * @param array $context
     *
     * @return string
     */
    public function render(Twig_Environment $twig, array $context = []);
    
    /**
     * @return array
     */
    public function getZones();
}
