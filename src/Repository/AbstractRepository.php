<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

abstract class AbstractRepository extends ServiceEntityRepository
{
    /**
     * AbstractRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $nameArray = explode('\\', get_class($this));
        $repositoryName = array_pop($nameArray);
        $entityClass = 'App\\Entity\\'.str_replace('Repository', '', $repositoryName);

        parent::__construct($registry, $entityClass);
    }

    public function save($entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}
