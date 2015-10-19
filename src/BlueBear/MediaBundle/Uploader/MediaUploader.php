<?php

namespace BlueBear\MediaBundle\Uploader;

use BlueBear\MediaBundle\Entity\Media;

class MediaUploader
{
    public function upload(Media $media)
    {
        $resourcePath = realpath(__DIR__ . '/../../../..') . '/resources';
        // if directory not exists, create it
        if (!file_exists($resourcePath)) {
            mkdir($resourcePath);
        }
        $uploadedFile = $media->getFile();

        if (!$media->getName()) {
            $media->setName($uploadedFile->getClientOriginalName());
        }
        // move uploaded file to resources dir
        $uploadedFile->move($resourcePath, $media->getName() . '.' . $uploadedFile->getClientOriginalExtension());
        $media->setFilepath('/resources/' . $media->getName());
        $media->setSize($uploadedFile->getClientSize());
        $media->setType($uploadedFile->getClientOriginalExtension());
    }
}
