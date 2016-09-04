<?php

namespace AppBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    use ControllerTrait;

    /**
     * @Template(":Page:show.html.twig")
     *
     * @param Request $request
     * @return array
     */
    public function showAction(Request $request)
    {
        $page = $this
            ->get('jk.cms.page_repository')
            ->findPublished($request->get('pageSlug'));
        $this->forward404Unless($page);

        return [
            'page' => $page
        ];
    }
}
