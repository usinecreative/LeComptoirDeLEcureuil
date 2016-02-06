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
            ->get('lag.cms.category_repository')
            ->findAll();
        return [
            'categories' => $categories
        ];
    }

    /**
     * @Template("@BlueBearCms/Dashboard/dashboard.html.twig")
     */
    public function dashboardAction()
    {
        $dashboard = $this
            ->get('bluebear.cms.dashboard_factory')
            ->create($this->getUser()->getLastLogin());

        return [
            'dashboard' => $dashboard
        ];
    }
}
