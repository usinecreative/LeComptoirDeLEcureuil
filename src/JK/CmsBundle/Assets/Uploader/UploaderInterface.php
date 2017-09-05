<?php

namespace JK\CmsBundle\Assets\Uploader;

use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Entity\MediaInterface;

interface UploaderInterface
{
    /**
     * @param              $data
     * @param              $type
     * @param Article|null $article
     *
     * @return MediaInterface
     */
    public function upload($data, $type, Article $article = null);
}
