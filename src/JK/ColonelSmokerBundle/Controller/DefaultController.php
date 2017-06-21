<?php

namespace JK\ColonelSmokerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JKColonelSmokerBundle:Default:index.html.twig');
    }
}
