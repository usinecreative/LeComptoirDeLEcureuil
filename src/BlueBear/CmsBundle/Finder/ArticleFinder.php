<?php

namespace BlueBear\CmsBundle\Finder;

use BlueBear\CmsBundle\Entity\Article;
use BlueBear\CmsBundle\Repository\ArticleRepository;
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
     * Return filtered articles
     *
     * @param ArticleFilter $filter
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
            ->createQueryBuilder('article')
        ;

        // only the published articles
        $queryBuilder
            ->andWhere('article.publicationStatus = :publication_status')
            ->setParameter('publication_status', Article::PUBLICATION_STATUS_PUBLISHED);

        // only with the published comments
        $queryBuilder
            ->addSelect('comments')
            ->leftJoin('article.comments', 'comments');

        // get parameters from filters
        $parameters = $filter->getParameters();

        // search an article by the category slug
        if ($parameters->has('categorySlug')) {
            $queryBuilder
                ->addSelect('category')
                ->leftJoin('article.category', 'category')
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
                ->addSelect('tag')
                ->leftJoin('article.tags', 'tag')
                ->andWhere('tag.slug = :tag_slug')
                ->setParameter('tag_slug', $parameters->get('tagSlug'));
        }

        // by default, articles are sorted by publication date
        $queryBuilder
            ->orderBy('article.publicationDate', 'desc');

        return $queryBuilder;
    }
}
