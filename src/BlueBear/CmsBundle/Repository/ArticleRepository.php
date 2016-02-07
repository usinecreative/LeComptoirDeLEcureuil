<?php

namespace BlueBear\CmsBundle\Repository;

use BlueBear\CmsBundle\Entity\Article;
use DateTime;
use LAG\DoctrineRepositoryBundle\Repository\DoctrineRepository;

/**
 * CategoryRepository
 *
 */
class ArticleRepository extends DoctrineRepository
{
    /**
     * @param int $count
     * @return array
     */
    public function findLatest($count = 6)
    {
        return $this
            ->createQueryBuilder('article')
            ->orderBy('article.id', 'desc')
            ->where('article.publicationStatus = :published')
            ->setParameter('published', Article::PUBLICATION_STATUS_PUBLISHED)
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $categorySlug
     * @param int $count
     * @return mixed
     */
    public function findByCategory($categorySlug, $count = 6)
    {
        return $this
            ->createQueryBuilder('article')
            ->orderBy('article.publicationDate', 'desc')
            ->innerJoin('article.category', 'category')
            ->where('article.publicationStatus = :published')
            ->andWhere('category.slug = :slug')
            ->setParameter('published', Article::PUBLICATION_STATUS_PUBLISHED)
            ->setParameter('slug', $categorySlug)
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find articles created after $date
     *
     * @param DateTime $date
     * @return array
     */
    public function findByDate(DateTime $date)
    {
        return $this
            ->createQueryBuilder('article')
            ->where('article.createdAt > :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array
     */
    public function findNotPublished()
    {
        return $this
            ->createQueryBuilder('article')
            ->where('article.publicationStatus != :publication_status')
            ->setParameter('publication_status', Article::PUBLICATION_STATUS_PUBLISHED)
            ->getQuery()
            ->getResult();
    }
}
