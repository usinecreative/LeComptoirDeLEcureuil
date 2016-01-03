<?php

namespace BlueBear\CmsBundle\Repository;

use DateTime;
use LAG\DoctrineRepositoryBundle\Repository\DoctrineRepository;

class CommentRepository extends DoctrineRepository
{
    /**
     * Return all comments created after $date
     *
     * @param DateTime $date
     * @return array
     */
    public function findByDate(DateTime $date)
    {
        return $this
            ->createQueryBuilder('comment')
            ->where('comment.createdAt > :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }
}
