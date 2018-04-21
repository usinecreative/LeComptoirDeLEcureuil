<?php

namespace App\Repository;

use App\Entity\Article;
use DateTime;
use Doctrine\Common\Collections\Collection;

class ArticleRepository extends AbstractRepository
{
    /**
     * Find the latest published articles.
     *
     * @param int $count
     *
     * @return Article[]
     */
    public function findLatest($count = 6)
    {
        return $this
            ->createQueryBuilder('article')
            ->orderBy('article.publicationDate', 'desc')
            ->where('article.publicationStatus = :published')
            ->andWhere('article.publicationDate <= :now')
            ->setParameter('published', Article::PUBLICATION_STATUS_PUBLISHED)
            ->setParameter('now', new DateTime())
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all articles in a given category.
     *
     * @param string $categorySlug
     * @param int    $count
     *
     * @return Article[]
     */
    public function findByCategory($categorySlug, $count = 6)
    {
        return $this
            ->createQueryBuilder('article')
            ->orderBy('article.publicationDate', 'desc')
            ->innerJoin('article.category', 'category')
            ->where('article.publicationStatus = :published')
            ->andWhere('article.publicationDate <= :now')
            ->andWhere('category.slug = :slug')
            ->setParameter('published', Article::PUBLICATION_STATUS_PUBLISHED)
            ->setParameter('slug', $categorySlug)
            ->setParameter('now', new DateTime())
            ->setMaxResults($count)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Find articles created after $date.
     *
     * @param DateTime $date
     *
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

    /**
     * @param array $terms
     * @param bool  $usePagination
     * @param int   $page
     *
     * @return Pagerfanta|Article[]
     */
    public function findByTerms(array $terms, $usePagination = true, $page = 1)
    {
        $queryBuilder = $this
            ->createQueryBuilder('article')
            ->leftJoin('article.category', 'category')
            ->leftJoin('article.tags', 'tag')
            ->orderBy('article.publicationDate', 'desc')
            ->where('article.publicationStatus = :publication_status')
            ->setParameter('publication_status', Article::PUBLICATION_STATUS_PUBLISHED)
            ->distinct(true)
        ;
        $i = 0;

        foreach ($terms as $term) {
            $queryBuilder
                ->andWhere('article.title like :term'.$i.' or category.name like :term'.$i.' or article.content like :term'.$i.' or tag.name like :term'.$i.'')
                ->setParameter('term'.$i, '%'.$term.'%')
            ;
            ++$i;
        }

        if (false === $usePagination) {
            return $queryBuilder
                ->getQuery()
                ->getResult()
            ;
        }
        $adapter = new DoctrineORMAdapter($queryBuilder, false, false);
        $pager = new Pagerfanta($adapter);
        $pager
            ->setMaxPerPage(10)
            ->setCurrentPage($page)
        ;

        return $pager;
    }
}