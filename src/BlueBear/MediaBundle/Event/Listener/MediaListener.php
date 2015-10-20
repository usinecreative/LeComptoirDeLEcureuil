<?php

namespace BlueBear\MediaBundle\Event\Listener;

use BlueBear\MediaBundle\Entity\Media;
use BlueBear\MediaBundle\Uploader\MediaUploader;
use Doctrine\ORM\Event\LifecycleEventArgs;

class MediaListener
{
    /**
     * @var MediaUploader
     */
    protected $uploader;

    public function __construct(MediaUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();

        if ($object instanceof Media) {
            $this->uploader->upload($object);
        }
    }
}
