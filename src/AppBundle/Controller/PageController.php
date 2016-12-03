<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
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
    
        if (!$page) {
            throw $this->createNotFoundException('Page not found');
        }

        return [
            'page' => $page
        ];
    }
}
