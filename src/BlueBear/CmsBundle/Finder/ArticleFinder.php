<?php

namespace BlueBear\CmsBundle\Finder;

use BlueBear\CmsBundle\Repository\ArticleRepository;
use BlueBear\CmsBundle\Finder\Filter\ArticleFilter;

class ArticleFinder
{
    /**
     * @var ArticleRepository
     */
    protected $repository;

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function find(ArticleFilter $filter)
    {
        $queryBuilder = $this->buildQueryBuilder($filter);
        $articles = $queryBuilder
            ->getQuery()
            ->getResult();

        return $articles;
    }

    public function findOne(ArticleFilter $filter)
    {
        $queryBuilder = $this->buildQueryBuilder($filter);
        $article = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult();

        return $article;
    }

    protected function buildQueryBuilder(ArticleFilter $filter)
    {
        $queryBuilder = $this
            ->repository
            ->createQueryBuilder('article');

        if ($filter->isValid()) {
            if ($filter->getCategorySlug()) {
                $queryBuilder
                    ->join('article.category', 'category')
                    ->andWhere('category.slug = :category')
                    ->setParameter('category', $filter->getCategorySlug());
            }
            if ($filter->getSlug()) {
                $queryBuilder
                    ->andWhere('article.slug = :slug')
                    ->setParameter('slug', $filter->getSlug());
            }
        }
        $queryBuilder
            ->orderBy('article.publicationDate', 'desc');
        return $queryBuilder;
    }
}
