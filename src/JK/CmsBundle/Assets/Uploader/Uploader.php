<?php

namespace JK\CmsBundle\Assets\Uploader;

use JK\CmsBundle\Repository\MediaRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader implements UploaderInterface
{
    /**
     * @var MediaRepository
     */
    private $mediaRepository;
    
    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }
    
    public function upload(UploadedFile $file)
    {
        $media = $this
            ->mediaRepository
            ->create()
        ;
        $media->setName($this->generateFileName().'.'.$file->getExtension());
        $media->setFileName($file->getFilename());
        $media->setFileType($file->getExtension());
        $media->setType($event->getType());
        $media->setSize($file->getSize());
    }
}
