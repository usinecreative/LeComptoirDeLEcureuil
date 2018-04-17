<?php

namespace JK\CmsBundle\Event\Subscriber;

use JK\CmsBundle\Assets\AssetsHelper;
use App\Repository\MediaRepository;
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
     * @var AssetsHelper
     */
    private $assetsHelper;

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
     * @param AssetsHelper    $assetsHelper
     */
    public function __construct(MediaRepository $mediaRepository, AssetsHelper $assetsHelper)
    {
        $this->mediaRepository = $mediaRepository;
        $this->assetsHelper = $assetsHelper;
    }

    /**
     * On file upload, a new media entity is created.
     *
     * @param PostPersistEvent $event
     */
    public function onUpload(PostPersistEvent $event)
    {
        /** @var File $file */
        $file = $event->getFile();

        // Create a new media with the uploaded file
        $media = $this
            ->mediaRepository
            ->create()
        ;
        $media->setName($this->generateFileName().'.'.$file->getExtension());
        $media->setFileName($file->getFilename());
        $media->setFileType($file->getExtension());
        $media->setType($event->getType());
        $media->setSize($file->getSize());
        $this
            ->mediaRepository
            ->save($media)
        ;

        // Add the url and the id of the created media
        $response = $event->getResponse();
        $response['mediaId'] = $media->getId();
        $response['mediaUrl'] = $this
            ->assetsHelper
            ->getMediaPath($media)
        ;
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
