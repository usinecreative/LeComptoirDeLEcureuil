<?php

namespace BlueBear\CmsBundle\Finder;

use DateTime;
use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Repository\ArticleRepository;
use BlueBear\CmsBundle\Finder\Filter\ArticleFilter;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

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
     * Return filtered articles.
     *
     * @param ArticleFilter $filter
     *
     * @return Pagerfanta
     */
    public function find(ArticleFilter $filter)
    {
        $queryBuilder = $this->buildQueryBuilder($filter);

        $adapter = new DoctrineORMAdapter($queryBuilder, false);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(11);
        $pager->setCurrentPage($filter->getParameter('page', 1));

        return $pager;
    }

    /**
     * Return one filtered article.
     *
     * @param ArticleFilter $filter
     *
     * @return Article
     *
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
     * Return enriched query builder according to filter parameter.
     *
     * @param ArticleFilter $filter
     *
     * @return QueryBuilder
     */
    protected function buildQueryBuilder(ArticleFilter $filter)
    {
        // create generic query builder
        $queryBuilder = $this
            ->repository
            ->createQueryBuilder('article')
            ->distinct()
        ;

        // only the published articles
        $queryBuilder
            ->andWhere('article.publicationStatus = :publication_status')
            ->andWhere('article.publicationDate <= :now')
            ->setParameter('publication_status', Article::PUBLICATION_STATUS_PUBLISHED)
            ->setParameter('now', new DateTime())
        ;

        // get parameters from filters
        $parameters = $filter->getParameters();

        // search an article by the category slug
        if ($parameters->has('categorySlug')) {
            $queryBuilder
                ->innerJoin('article.category', 'category')
                ->andWhere('category.slug = :category')
                ->setParameter('category', $parameters->get('categorySlug'));
        }

        // search an article by its slug
        if ($parameters->has('slug')) {
            $queryBuilder
                ->andWhere('article.slug = :slug')
                ->setParameter('slug', $parameters->get('slug'));
        }

        // search articles by tag slug
        if ($parameters->has('tagSlug')) {
            $queryBuilder
                ->innerJoin('article.tags', 'tag')
                ->andWhere('tag.slug = :tag_slug')
                ->setParameter('tag_slug', $parameters->get('tagSlug'));
        }

        // by default, articles are sorted by publication date
        $queryBuilder
            ->addOrderBy('article.publicationDate', 'DESC')
        ;

        return $queryBuilder;
    }
}
