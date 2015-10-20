<?php

namespace BlueBear\MediaBundle\Uploader;

use BlueBear\MediaBundle\Entity\Media;
use Exception;

class MediaUploader
{
    protected $resourcesPath;

    public function __construct($resourcesPath)
    {
        $this->resourcesPath = $resourcesPath;
    }

    public function upload(Media $media)
    {
        $uploadedFile = $media->getFile();
        // media should have an uploaded file
        if (!$uploadedFile) {
            return;
        }
        // guess media type from extension
        $mediaType = $this->guessType($uploadedFile->getClientOriginalExtension());
        // we will move the uploaded file into a directory according to its media type
        $resourcePath = realpath(__DIR__ . '/../../../..') . '/resources/' . $mediaType;
        // if directory not exists, create it
        if (!file_exists($resourcePath)) {
            mkdir($resourcePath);
        }
        // if no name is set, we take the original one
        if (!$media->getName()) {
            $media->setName($uploadedFile->getClientOriginalName());
        }
        // new filename
        $filename = $media->getName() . '.' . $uploadedFile->getClientOriginalExtension();
        // move uploaded file to resources dir
        $uploadedFile->move($resourcePath, $filename);
        // updating media object
        $media->setFilepath('/resources/' . $filename);
        $media->setFilename($filename);
        $media->setSize($uploadedFile->getClientSize());
        $media->setType($mediaType);
    }

    protected function guessType($extension)
    {
        $imagesExtension = ['png', 'jpg'];

        if (in_array($extension, $imagesExtension)) {
            $type = Media::MEDIA_TYPE_IMAGE;
        } else {
            $type = Media::MEDIA_TYPE_FILE;
        }
        return $type;
    }
}
