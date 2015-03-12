<?php

namespace LeComptoirDeLEcureuil\FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Template()
     * @return array
     */
    public function indexAction()
    {
        return [];
    }
}
