<?php

namespace BlueBear\CmsBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use DateTime;
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
            ->get('jk.cms.category_repository')
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
        $lastLogin = $this->getUser()->getLastLogin();

        if (!$lastLogin) {
            $lastLogin = new DateTime();
        }

        $dashboard = $this
            ->get('bluebear.cms.dashboard_factory')
            ->create($lastLogin);

        return [
            'dashboard' => $dashboard
        ];
    }
}
