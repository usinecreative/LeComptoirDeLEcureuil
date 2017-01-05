<?php

namespace BlueBear\CmsBundle\Repository;

use BlueBear\CmsBundle\Entity\Page;
use BlueBear\CmsBundle\Publication\PublicationStatus;
use DateTime;
use LAG\AdminBundle\Repository\DoctrineRepository;

class PageRepository extends DoctrineRepository
{
    /**
     * Return a published page by its slug.
     *
     * @param $pageSlug
     *
     * @return Page|null
     */
    public function findPublished($pageSlug)
    {
        return $this
            ->createQueryBuilder('page')
            ->where('page.publicationStatus = :publication_status')
            ->andWhere('page.slug = :slug')
            ->andWhere('page.publicationDate < :publication_date')
            ->setParameter('publication_status', PublicationStatus::PUBLICATION_STATUS_PUBLISHED)
            ->setParameter('slug', $pageSlug)
            ->setParameter('publication_date', new DateTime())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
