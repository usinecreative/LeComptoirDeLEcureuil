<?php

namespace AppBundle\Controller;

use BlueBear\BaseBundle\Behavior\ControllerTrait;
use BlueBear\CmsBundle\Entity\Category;
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
     * @Template(":Article:show.html.twig")
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
     * @Template(":Article:filter.html.twig")
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
            'filter' => $filter,
            // title is dynamic in filter action
            'title' => $this->getFilterTitle($filter)
        ];
    }

    protected function getFilterTitle(ArticleFilter $filter)
    {
        $parameters = $filter->getParameters();
        $title = implode(',', $parameters->all());

        if ($parameters->has('categorySlug')) {
            /** @var Category $category */
            $category = $this
                ->get('lag.cms.category_repository')
                ->findOneBy([
                    'slug' => $parameters->get('categorySlug')
                ]);
            $title = $category->getName();
        }
        return $title;
    }
}
