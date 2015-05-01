<?php

namespace BlueBear\CmsBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CmsController extends Controller
{
    use ControllerTrait;

    /**
     * @Template()
     * @return array
     */
    public function homepageAction()
    {
        $categories = $this
            ->get('doctrine')
            ->getRepository('BlueBearCmsBundle:Category')
            ->findAll();
        return [
            'categories' => $categories
        ];
    }
}