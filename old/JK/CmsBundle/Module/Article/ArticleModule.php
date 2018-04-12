<?php

namespace JK\CmsBundle\Module\Article;

use JK\CmsBundle\Module\ModuleInterface;
use JK\CmsBundle\Repository\ArticleRepository;
use Twig_Environment;

class ArticleModule implements ModuleInterface
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function render(Twig_Environment $twig, array $context = [])
    {
        if (!array_key_exists('categorySlug', $context)) {
            return '';
        }
        $articles = $this
            ->articleRepository
            ->findByCategory($context['categorySlug'], 5)
        ;

        return $twig->render('@JKCms/Module/article.html.twig', [
            'articles' => $articles,
        ]);
    }

    public function getName()
    {
        return 'article';
    }

    /**
     * @return array
     */
    public function getZones()
    {
        return [
            'left',
        ];
    }
}
