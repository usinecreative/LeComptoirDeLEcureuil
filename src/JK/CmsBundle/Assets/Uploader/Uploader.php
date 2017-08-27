<?php

namespace JK\CmsBundle\Assets\Uploader;

use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Repository\MediaRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader implements UploaderInterface
{
    /**
     * @var MediaRepository
     */
    private $mediaRepository;
    
    /**
     * @var string
     */
    private $uploadDirectory;
    
    public function __construct($uploadDirectory, MediaRepository $mediaRepository)
    {
        $this->uploadDirectory = $uploadDirectory;
        $this->mediaRepository = $mediaRepository;
    }
    
    public function upload(UploadedFile $file, Article $article = null)
    {
        $media = $this
            ->mediaRepository
            ->create()
        ;
        $name = $this->generateFileName();
    
        if (null !== $article) {
            $name = 'Media for '.$article->getTitle().'-'.uniqid('assets');
        }
        $nameWithExtension = $name.'.'.$file->getClientOriginalExtension();
        
        $media->setName($nameWithExtension);
        $media->setFileName($name);
        $media->setFileType($file->getClientOriginalExtension());
        $media->setType('upload');
        $media->setSize($file->getSize());
        
        $file->move($this->uploadDirectory, $nameWithExtension);
        
        $this
            ->mediaRepository
            ->save($media)
        ;
    
        return $media;
    }
    
    /**
     * Generate an unique default file name.
     *
     * @return string
     */
    protected function generateFileName()
    {
        return uniqid('assets-');
    }
}
