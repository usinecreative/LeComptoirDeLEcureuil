<?php

namespace BlueBear\CmsBundle\Finder;

use BlueBear\CmsBundle\Repository\ArticleRepository;
use BlueBear\CmsBundle\Finder\Filter\ArticleFilter;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

class ArticleFinder
{
    /**
     * @var ArticleRepository
     */
    protected $repository;

    /**
     * ArticleFinder constructor.
     *
     * @param ArticleRepository $repository
     */
    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Return filtered articles
     *
     * @param ArticleFilter $filter
     * @return array
     */
    public function find(ArticleFilter $filter)
    {
        $queryBuilder = $this->buildQueryBuilder($filter);
        $articles = $queryBuilder
            ->getQuery()
            ->getResult();

        return $articles;
    }

    /**
     * Return one filtered article
     *
     * @param ArticleFilter $filter
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function findOne(ArticleFilter $filter)
    {
        $queryBuilder = $this->buildQueryBuilder($filter);
        $article = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult();

        return $article;
    }

    /**
     * Return enriched query builder according to filter parameter
     *
     * @param ArticleFilter $filter
     * @return QueryBuilder
     */
    protected function buildQueryBuilder(ArticleFilter $filter)
    {
        // create generic query builder
        $queryBuilder = $this
            ->repository
            ->createQueryBuilder('article');
        // get parameters from filters
        $parameters = $filter->getParameters();

        // search an article by the category slug
        if ($parameters->has('categorySlug')) {
            $queryBuilder
                ->join('article.category', 'category')
                ->andWhere('category.slug = :category')
                ->setParameter('category', $parameters->get('categorySlug'));
        }

        // search an article by its slug
        if ($parameters->has('slug')) {
            $queryBuilder
                ->andWhere('article.slug = :slug')
                ->setParameter('slug', $parameters->get('slug'));
        }
        // by default, articles are sorted by publication date
        $queryBuilder
            ->orderBy('article.publicationDate', 'desc');

        return $queryBuilder;
    }
}
