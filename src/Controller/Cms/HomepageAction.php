<?php

namespace App\Controller\Cms;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;

class HomepageAction
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * HomepageAction constructor.
     *
     * @param \Twig_Environment  $twig
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(\Twig_Environment $twig, CategoryRepository $categoryRepository)
    {
        $this->twig = $twig;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return Response
     */
    public function __invoke()
    {
        $categories = $this
            ->categoryRepository
            ->findAll()
        ;
        $content = $this
            ->twig
            ->render(':cms/homepage:homepage.html.twig', [
                'categories' => $categories,
            ])
        ;

        return new Response($content);
    }
}
