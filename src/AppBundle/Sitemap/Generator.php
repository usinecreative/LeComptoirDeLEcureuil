<?php

namespace AppBundle\Sitemap;

use BlueBear\CmsBundle\Repository\ArticleRepository;
use AppBundle\Sitemap\Item\Item;
use Symfony\Component\Routing\RouterInterface;

class Generator
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var ArticleRepository
     */
    protected $articleRepository;

    /**
     * Generator constructor.
     * @param RouterInterface $router
     * @param ArticleRepository $articleRepository
     */
    public function __construct(
        RouterInterface $router,
        ArticleRepository $articleRepository
    ) {
        $this->router = $router;
        $this->articleRepository = $articleRepository;
    }

    public function generate()
    {
        $items = [];
        // find all published articles
        $articles = $this
            ->articleRepository
            ->findPublished();

        foreach ($articles as $article) {
            // generate article absolute url
            $url = $this
                ->router
                ->generate('lecomptoir.article.show', $article->getUrlParameters(), RouterInterface::ABSOLUTE_URL);

            // add it to the collection
            $items[] = new Item($url, 'daily');
        }

        return $items;
    }
}
