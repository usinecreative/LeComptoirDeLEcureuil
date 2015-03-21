<?php

namespace BlueBear\CmsBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BackofficeController extends Controller
{
    use ControllerTrait;

    /**
     * @Template()
     * @param $name
     * @param Request $request
     * @return array
     */
    public function listContentAction($name, Request $request)
    {
        return [];
    }
}