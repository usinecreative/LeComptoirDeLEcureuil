<?php

namespace LeComptoirDeLEcureuil\BackBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    use ControllerTrait;

    /**
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}