<?php

namespace BlueBear\MediaBundle\Manager;

use BlueBear\BaseBundle\Behavior\ManagerTrait;
use BlueBear\MediaBundle\Repository\MediaRepository;

class MediaManager
{
    use ManagerTrait;

    /**
     * Return current manager repository
     *
     * @return MediaRepository
     */
    protected function getRepository()
    {
        return $this
            ->getEntityManager()
            ->getRepository('BlueBearMediaBundle:Media');
    }
}