<?php

namespace JK\CmsBundle\Form\Handler;

use JK\CmsBundle\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class SearchFormHandler
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * SearchFormHandler constructor.
     *
     * @param ArticleRepository $articleRepository
     * @param Twig_Environment  $twig
     */
    public function __construct(ArticleRepository $articleRepository, Twig_Environment $twig)
    {
        $this->articleRepository = $articleRepository;
        $this->twig = $twig;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        $search = $request->get('search');
        $page = $request->get('page', 1);
        $terms = $this->extractTerms($search);

        $pager = $this
            ->articleRepository
            ->findByTerms($terms, true, $page);

        $content = $this
            ->twig
            ->render(':Article:filter.html.twig', [
                'title' => $this->generateTitle($terms),
                'articles' => $pager->getCurrentPageResults(),
                'pager' => $pager,
            ])
        ;

        return new Response($content);
    }

    /**
     * @param string $search
     *
     * @return array
     */
    private function extractTerms($search)
    {
        $terms = [];

        $search = str_replace(',', ' ', $search);
        $notTrimmedTerms = explode(' ', $search);

        foreach ($notTrimmedTerms as $term) {
            $terms[trim($term)] = trim($term);
        }

        return $terms;
    }

    /**
     * @param array $terms
     *
     * @return string
     */
    private function generateTitle(array $terms)
    {
        if (count($terms) > 1) {
            $title = 'Recherche pour les mots "'.implode('", "', $terms).'"';
        } else {
            $title = 'Recherche pour le mot "'.array_pop($terms).'"';
        }

        return $title;
    }
}
