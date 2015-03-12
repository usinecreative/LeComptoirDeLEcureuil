<?php

namespace BlueBear\CmsBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BackofficeController extends Controller
{
    use ControllerTrait;

    /**
     * @Template()
     * @return array
     */
    public function listContentAction()
    {
        return [];
    }
}