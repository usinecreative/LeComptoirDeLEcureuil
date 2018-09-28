<?php

namespace App\Repository;

use App\Entity\Page;
use DateTime;

class PageRepository extends AbstractRepository
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
            ->setParameter('publication_status', Page::PUBLICATION_STATUS_PUBLISHED)
            ->setParameter('slug', $pageSlug)
            ->setParameter('publication_date', new DateTime())
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
