<?php

namespace LeComptoirDeLEcureuil\FrontBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use BlueBear\CmsBundle\Entity\Article;
use BlueBear\CmsBundle\Service\Filter\ArticleFilter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    use ControllerTrait;

    public function showAction(Article $article)
    {

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
        $this
            ->get('bluebear.cms.article_finder')
            ->find($filter);

        return [
            'articles' => []
        ];
    }
}
