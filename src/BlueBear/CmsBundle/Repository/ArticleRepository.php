<?php

namespace BlueBear\CmsBundle\Repository;

use BlueBear\CmsBundle\Entity\Article;
use DateTime;
use Doctrine\Common\Collections\Collection;
use LAG\AdminBundle\Repository\DoctrineRepository;

/**
 * CategoryRepository
 *
 */
class ArticleRepository extends DoctrineRepository
{
    /**
     * Find latest published articles.
     *
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
     * Find articles created after $date.
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
     * Find not published articles.
     *
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

    /**
     * Find published articles.
     *
     * @return Article[]|Collection
     */
    public function findPublished()
    {
        return $this
            ->createQueryBuilder('article')
            ->where('article.publicationStatus = :publication_status')
            ->setParameter('publication_status', Article::PUBLICATION_STATUS_PUBLISHED)
            ->orderBy('article.publicationDate', 'desc')
            ->getQuery()
            ->getResult();
    }

    public function findByTag($tag)
    {
        return $this
            ->createQueryBuilder('article')
            ->join('article.tags', 'tag')
            ->where('tag.slug = :tag')
            ->setParameter('tag', $tag)
        ;
    }
}
