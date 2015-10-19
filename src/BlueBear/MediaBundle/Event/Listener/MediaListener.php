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
    protected $manager;

    public function __construct(MediaUploader $manager)
    {
        $this->manager = $manager;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $object = $args->getObject();

        if ($object instanceof Media) {
            $this->manager->upload($object);
        }
    }
}
