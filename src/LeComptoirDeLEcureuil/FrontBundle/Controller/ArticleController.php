<?php

namespace LeComptoirDeLEcureuil\FrontBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use BlueBear\CmsBundle\Finder\Filter\ArticleFilter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Display an article or a list of filtered articles
 */
class ArticleController extends Controller
{
    use ControllerTrait;

    /**
     * @Template()
     * @param Request $request
     * @return array
     */
    public function showAction(Request $request)
    {
        $filter = new ArticleFilter();
        $filter->handleRequest($request);
        $article = $this
            ->get('bluebear.cms.article_finder')
            ->findOne($filter);

        return [
            'article' => $article
        ];
    }

    /**
     * @Template()
     * @param Request $request
     * @return array
     */
    public function filterAction(Request $request)
    {
        $filter = new ArticleFilter();
        $filter->handleRequest($request);
        $articles = $this
            ->get('bluebear.cms.article_finder')
            ->find($filter);

        return [
            'articles' => $articles,
            'filter' => $filter
        ];
    }
}
