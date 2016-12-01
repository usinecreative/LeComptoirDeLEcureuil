<?php

namespace JK\CmsBundle\Event\Subscriber;

use JK\CmsBundle\Repository\MediaRepository;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\File;

class UploadSubscriber implements EventSubscriberInterface
{
    /**
     * @var MediaRepository
     */
    private $mediaRepository;

    public static function getSubscribedEvents()
    {
        return [
            'oneup_uploader.post_persist' => 'onUpload',
        ];
    }

    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    public function onUpload(PostPersistEvent $event)
    {
        if ('gallery' !== $event->getType()) {
            return;
        }
        /** @var File $file */
        $file = $event->getFile();
        $media = $this
            ->mediaRepository
            ->create();

        $media->setName($this->generateFileName().'.'.$file->getExtension());
        $media->setFileName($file->getFilename());
        $media->setFileType($file->getExtension());
        $media->setType($event->getType());
        $media->setSize($file->getSize());

        $this
            ->mediaRepository
            ->save($media);
    }

    protected function generateFileName()
    {
        return uniqid('assets-');
    }
}
