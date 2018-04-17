<?php

namespace App\Service\Assets\Uploader;

use App\Entity\Article;
use App\Entity\MediaInterface;

interface UploaderInterface
{
    /**
     * @param              $data
     * @param Article|null $article
     *
     * @return MediaInterface
     */
    public function upload(array $data, Article $article = null);
}
