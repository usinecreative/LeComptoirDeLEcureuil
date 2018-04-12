<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * CategoryRepository.
 */
class CategoryRepository extends ServiceEntityRepository
{
    /**
     * CategoryRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * Return categories that should be display in homepage. They are indexed by slug.
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
            ->getResult()
        ;
    }
}
