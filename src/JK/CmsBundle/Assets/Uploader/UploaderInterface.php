<?php

namespace JK\CmsBundle\Assets\Uploader;

use JK\CmsBundle\Entity\Article;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploaderInterface
{
    public function upload(UploadedFile $file, Article $article = null);
}
