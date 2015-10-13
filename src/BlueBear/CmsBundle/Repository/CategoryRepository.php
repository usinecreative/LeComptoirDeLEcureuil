<?php

namespace BlueBear\CmsBundle\Repository;

use BlueBear\CmsBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 */
class CategoryRepository extends EntityRepository
{
    /**
     * Return categories that should be display in homepage. They are indexed by slug
     *
     * @return Category[]
     */
    public function findForHomepage()
    {
        return $this
            ->createQueryBuilder('category', 'category.slug')
            ->where('category.displayInHomepage = :display')
            ->setParameter('display', true)
            ->getQuery()
            ->getResult();
    }
}
