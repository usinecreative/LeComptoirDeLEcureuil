<?php

namespace JK\CmsBundle\Event\Subscriber;

use JK\CmsBundle\Entity\Article;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Routing\RouterInterface;

class ArticleSubscriber implements EventSubscriber
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate,
        ];
    }

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function preUpdate(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if ($entity instanceof Article && $entity->getPublicationDate()) {
            $canonical = $this
                ->router
                ->generate('lecomptoir.article.show', $entity->getUrlParameters());
            $entity
                ->setCanonical($canonical);
        }
    }
}
