<?php

namespace BlueBear\CmsBundle\Feed\Factory;

use JK\CmsBundle\Entity\Article;
use BlueBear\CmsBundle\Feed\Item\FeedItem;
use Symfony\Component\Routing\RouterInterface;

class ArticleItemFactory
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * ArticleItemFactory constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Create a feed item from an array of articles.
     *
     * @param Article[] $articles
     *
     * @return array
     */
    public function create(array $articles)
    {
        $items = [];

        foreach ($articles as $article) {
            $items[] = new FeedItem(
                $article->getTitle(),
                substr($article->getContent(), 0, 500).'...',
                $this->router->generate('lecomptoir.article.show', $article->getUrlParameters()),
                $article->getPublicationDate()
            );
        }

        return $items;
    }
}
