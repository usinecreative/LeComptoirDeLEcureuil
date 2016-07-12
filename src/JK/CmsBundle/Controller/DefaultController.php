<?php

namespace JK\CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JKCmsBundle:Default:index.html.twig');
    }
}
