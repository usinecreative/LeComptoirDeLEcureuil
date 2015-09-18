<?php

namespace BlueBear\CmsBundle\Repository;

use BlueBear\CmsBundle\Entity\Article;
use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 */
class ArticleRepository extends EntityRepository
{
    public function findLatest($count = 6)
    {
        return $this
            ->createQueryBuilder('article')
            ->orderBy('article.id', 'asc')
            ->where('article.publicationStatus = :published')
            ->setParameter('published', Article::PUBLICATION_STATUS_PUBLISHED)
            ->setMaxResults($count)
            ->getQuery()
            ->getResult();
    }
}
