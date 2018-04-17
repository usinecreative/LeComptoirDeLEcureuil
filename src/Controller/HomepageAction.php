<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class HomepageAction
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * HomepageAction constructor.
     *
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     * @param Twig_Environment $twig
     */
    public function __construct(
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        Twig_Environment $twig
    ) {
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->twig = $twig;
    }

    /**
     * @return Response
     */
    public function __invoke()
    {
        $latestArticles = $this
            ->articleRepository
            ->findLatest()
        ;
        $categories = $this
            ->categoryRepository
            ->findForHomepage()
        ;

        $content = $this
            ->twig
            ->render('Pages/homepage.html.twig', [
                'latestArticles' => $latestArticles,
                'categories' => $categories,
            ])
        ;

        return new Response($content);
    }
}
