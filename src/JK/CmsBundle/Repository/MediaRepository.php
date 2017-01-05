<?php

namespace JK\CmsBundle\Repository;

use Exception;
use JK\CmsBundle\Entity\MediaInterface;
use LAG\AdminBundle\Repository\DoctrineRepository;

class MediaRepository extends DoctrineRepository
{
    /**
     * Return a new instance of the configured Media class.
     *
     * @return MediaInterface
     *
     * @throws Exception
     */
    public function create()
    {
        $className = $this->getClassName();

        $media = new $className();

        if (!$media instanceof MediaInterface) {
            throw new Exception('Media class '.$className.' should extends '.MediaInterface::class);
        }

        return $media;
    }

    public function findAll()
    {
        return $this
            ->findBy([], [
                'updatedAt' => 'DESC',
            ]);
    }
}
