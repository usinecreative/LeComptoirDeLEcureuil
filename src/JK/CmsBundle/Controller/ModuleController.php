<?php

namespace JK\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleController extends Controller
{
    public function renderAction(Request $request)
    {
        if (null === $request->get('zone')) {
            return new Response();
        }
        $content = $this
            ->get('cms.module.renderer')
            ->render($request->get('zone'))
        ;
    
        return new Response($content);
    }
}
