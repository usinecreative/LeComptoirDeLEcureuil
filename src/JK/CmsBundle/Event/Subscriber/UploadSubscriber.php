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

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'oneup_uploader.post_persist' => 'onUpload',
        ];
    }

    /**
     * UploadSubscriber constructor.
     *
     * @param MediaRepository $mediaRepository
     */
    public function __construct(MediaRepository $mediaRepository)
    {
        $this->mediaRepository = $mediaRepository;
    }

    /**
     * On file upload, a new media entity is created.
     *
     * @param PostPersistEvent $event
     */
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
