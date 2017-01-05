<?php

namespace AppBundle\Sitemap;

use JK\CmsBundle\Repository\ArticleRepository;
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

    /**
     * Cache directory path.
     *
     * @var string
     */
    protected $cacheDirectory;

    /**
     * Generator constructor.
     *
     * @param $cacheDirectory
     * @param RouterInterface   $router
     * @param ArticleRepository $articleRepository
     * @param Twig_Environment  $twig
     *
     * @throws Exception
     */
    public function __construct(
        $cacheDirectory,
        RouterInterface $router,
        ArticleRepository $articleRepository,
        Twig_Environment $twig
    ) {
        $this->router = $router;
        $this->articleRepository = $articleRepository;
        $this->twig = $twig;
        $this->cacheDirectory = $cacheDirectory;

        if (!file_exists($this->cacheDirectory)) {
            throw new Exception("Invalid cache directory {$this->cacheDirectory} for sitemap generator");
        }
    }

    /**
     * Generate a xml sitemap file and return its filepath.
     *
     * @return string
     */
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
        // homepage
        $items[] = new Item(
            $this->router->generate('lecomptoir.homepage', [], RouterInterface::ABSOLUTE_URL),
            'weekly'
        );
        // contact page
        $items[] = new Item(
            $this->router->generate('lecomptoir.contact', [], RouterInterface::ABSOLUTE_URL),
            'weekly'
        );
        $items[] = new Item(
            $this->router->generate('lecomptoir.about', [], RouterInterface::ABSOLUTE_URL),
            'weekly'
        );

        $content = $this
            ->twig
            ->render(':Sitemap:sitemap.xml.twig', [
                'items' => $items,
            ]);
        $fileSystem = new Filesystem();
        $sitemap = $fileSystem->tempnam($this->cacheDirectory, 'sitemap').'.xml';
        $fileSystem->dumpFile($sitemap, $content);

        return $sitemap;
    }
}
