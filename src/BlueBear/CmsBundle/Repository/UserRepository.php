<?php

namespace BlueBear\CmsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function save($user)
    {
        $this->_em->persist($user);
        $this->_em->flush($user);
    }
}
