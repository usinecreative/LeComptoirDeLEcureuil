<?php

namespace LeComptoirDeLEcureuil\FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    /**
     * @Template(":Main:index.html.twig")
     * @return array
     */
    public function indexAction()
    {
        // latest published articles
        $latestArticles = $this
            ->get('lag.cms.article_repository')
            ->findLatest();
        // category configured for display in homepage
        $categories = $this
            ->get('lag.cms.category_repository')
            ->findForHomepage();

        return [
            'latestArticles' => $latestArticles,
            'categories' => $categories,
        ];
    }
}
