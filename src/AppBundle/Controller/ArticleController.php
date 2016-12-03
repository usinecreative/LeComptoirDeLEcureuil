<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\CommentType;
use BlueBear\CmsBundle\Entity\Article;
use BlueBear\CmsBundle\Entity\Category;
use BlueBear\CmsBundle\Finder\Filter\ArticleFilter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Display an article or a list of filtered articles
 */
class ArticleController extends Controller
{
    /**
     * @Template(":Article:show.html.twig")
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function showAction(Request $request)
    {
        $filter = new ArticleFilter();
        $filter->handleRequest($request);
        $article = $this
            ->get('bluebear.cms.article_finder')
            ->findOne($filter);

        $commentForm = $this->createForm(CommentType::class, [
            'article' => $article
        ], [
            'articleRepository' => $this->get('jk.cms.article_repository')
        ]);
        $commentForm->handleRequest($request);

        if ($commentForm->isValid()) {
            $this
                ->get('app_comment_form_handler')
                ->handle($commentForm, $request);

            $url = $this->generateUrl('lecomptoir.article.show', $article->getUrlParameters()).'#category-link';

            return $this->redirect($url);
        }

        return [
            'article' => $article,
            'commentForm' => $commentForm->createView()
        ];
    }

    /**
     * @Template(":Article:filter.html.twig")
     *
     * @param Request $request
     * @return array
     */
    public function filterAction(Request $request)
    {
        $filter = new ArticleFilter();
        $filter->handleRequest($request);
        $pager = $this
            ->get('bluebear.cms.article_finder')
            ->find($filter);

        return [
            'articles' => $pager->getCurrentPageResults(),
            'pager' => $pager,
            'filter' => $filter,
            // title is dynamic in filter action
            'title' => $this->getFilterTitle($filter)
        ];
    }

    /**
     * @Template(":Article:preview.html.twig")
     *
     * @param Article $article
     *
     * @return array
     */
    public function previewAction(Article $article)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return [
            'article' => $article
        ];
    }

    /**
     * @param ArticleFilter $filter
     *
     * @return string
     */
    protected function getFilterTitle(ArticleFilter $filter)
    {
        $parameters = $filter->getParameters();
        $title = implode(',', $parameters->all());

        if ($parameters->has('categorySlug')) {
            /** @var Category $category */
            $category = $this
                ->get('jk.cms.category_repository')
                ->findOneBy([
                    'slug' => $parameters->get('categorySlug')
                ]);
            $title = $category->getName();
        }
        return $title;
    }
}
