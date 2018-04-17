<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\Type\AddCommentType;
use BlueBear\CmsBundle\Finder\Filter\ArticleFilter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Display an article or a list of filtered articles.
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

        if (null === $article) {
            throw new NotFoundHttpException('Article not found');
        }
        $comment = new Comment();
        $comment->setArticle($article);
        $commentForm = $this->createForm(AddCommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isValid()) {
            // save the new Comment
            $this
                ->get('jk.cms.comment_repository')
                ->save($comment);

            // notify older Comments authors
            $this
                ->get('cms.comment.comment_mailer')
                ->sendNewCommentMail($comment);

            // redirect to the new Comment
            $url = $this->generateUrl(
                'lecomptoir.article.show',
                    $article->getUrlParameters()
                ).'#comment-'.$comment->getId();

            return $this->redirect($url);
        }

        return [
            'article' => $article,
            'commentForm' => $commentForm->createView(),
        ];
    }

    /**
     * @Template(":Article:filter.html.twig")
     *
     * @param Request $request
     *
     * @return array
     */
    public function filterAction(Request $request)
    {
        $filter = new ArticleFilter();
        $filter->handleRequest($request);
        $pager = $this
            ->get('bluebear.cms.article_finder')
            ->find($filter)
        ;

        return [
            'articles' => $pager->getCurrentPageResults(),
            'pager' => $pager,
            'filter' => $filter,
            // title is dynamic in filter action
            'title' => $this->getFilterTitle($filter),
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
            'article' => $article,
        ];
    }

    /**
     * Remove subscriptions for an User and an Article.
     *
     * @param string $slug
     * @param string $email
     *
     * @return RedirectResponse
     */
    public function unsubscribeAction($slug, $email)
    {
        $this
            ->get('jk.cms.comment_repository')
            ->unsubscribe($slug, $email);
        $this
            ->addFlash('success', $this->get('translator')->trans('cms.comment.unsubscribe_success'));

        return $this->redirectToRoute('lecomptoir.homepage');
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
            $category = $this
                ->get('jk.cms.category_repository')
                ->findOneBy([
                    'slug' => $parameters->get('categorySlug'),
                ]);

            if (null === $category) {
                throw new NotFoundHttpException();
            }
            $title = $category->getName();
        }

        return $title;
    }
}
