<?php

namespace BlueBear\CmsBundle\Manager;

use BlueBear\BaseBundle\Behavior\ManagerTrait;
use BlueBear\CmsBundle\Entity\Category;
use BlueBear\CmsBundle\Repository\CategoryRepository;

class CategoryManager
{
    use ManagerTrait;

    public function findAll()
    {
        return $this
            ->getRepository()
            ->createQueryBuilder('category')
            ->where('category.publicationStatus = :published')
            ->setParameters([
                'published' => Category::PUBLICATION_STATUS_PUBLISHED,
            ]);
    }

    /**
     * Return current manager repository.
     *
     * @return CategoryRepository
     */
    protected function getRepository()
    {
        return $this->getEntityManager()->getRepository('BlueBearCmsBundle:Category');
    }
}
