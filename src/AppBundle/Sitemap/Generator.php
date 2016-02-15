<?php

namespace AppBundle\Sitemap;

use BlueBear\CmsBundle\Repository\ArticleRepository;
use AppBundle\Sitemap\Item\Item;
use Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\RouterInterface;
use Twig_Environment;

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
     * @var Twig_Environment
     */
    protected $twig;
    private $cacheDirectory;

    /**
     * Generator constructor.
     * @param $cacheDirectory
     * @param RouterInterface $router
     * @param ArticleRepository $articleRepository
     * @param Twig_Environment $twig
     */
    public function __construct(
        $cacheDirectory,
        RouterInterface $router,
        ArticleRepository $articleRepository,
        Twig_Environment $twig
    )
    {
        $this->router = $router;
        $this->articleRepository = $articleRepository;
        $this->twig = $twig;
        $this->cacheDirectory = $cacheDirectory;

        if (!file_exists($this->cacheDirectory)) {
            throw new Exception("Invalid cache directory {$this->cacheDirectory} for sitemap generator");
        }
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
        $content = $this
            ->twig
            ->render(':Sitemap:sitemap.xml.twig', [
                'items' => $items
            ]);
        $fileSystem = new Filesystem();
        $sitemap = $fileSystem->tempnam($this->cacheDirectory, 'sitemap') . '.xml';
        $fileSystem->dumpFile($sitemap, $content);

        return $sitemap;
    }
}
