<?php

namespace JK\CmsBundle\Module;


use JK\CmsBundle\Repository\ModuleRepository;
use LogicException;
use Twig_Environment;

class ModuleRenderer
{
    /**
     * @var array
     */
    private $allowedZones;
    
    /**
     * @var Twig_Environment
     */
    private $twig;
    
    /**
     * @var ModuleRepository
     */
    private $moduleRepository;
    
    /**
     * ModuleRenderer constructor.
     *
     * @param Twig_Environment $twig
     * @param ModuleRepository $moduleRepository
     */
    public function __construct(Twig_Environment $twig, ModuleRepository $moduleRepository)
    {
        $this->allowedZones = [
            'left',
        ];
        $this->twig = $twig;
        $this->moduleRepository = $moduleRepository;
    }
    
    /**
     * @param string $zone Zone name
     *
     * @return string
     */
    public function renderZone($zone)
    {
        if (!in_array($zone, $this->allowedZones)) {
            throw new LogicException('Zone "'.$zone.'" is not allowed for Module rendering');
        }
        $modules = $this
            ->moduleRepository
            ->load($zone)
        ;
        $content = '';
        $context = [];
    
        if ('left' === $zone) {
            $context['categorySlug'] = 'breves-de-comptoir';
        }
    
        foreach ($modules as $module) {
            $content .= $module->render($this->twig, $context);
        }
    
        return $content;
    }
    
    /**
     * @param string $name Module name
     *
     * @return string
     */
    public function render($name)
    {
        $module = $this
            ->moduleRepository
            ->get($name)
        ;
    
        return $module->render($this->twig);
    }
}
