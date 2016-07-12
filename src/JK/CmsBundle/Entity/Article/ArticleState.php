<?php

namespace JK\CmsBundle\Entity\Article;

class ArticleState
{
    const PUBLICATION_STATUS_DRAFT = 'draft';
    const PUBLICATION_STATUS_VALIDATION = 'require_validation';
    const PUBLICATION_STATUS_PUBLISHED = 'published';
    const PUBLICATION_STATUS_UNPUBLISHED = 'unpublished';
}
