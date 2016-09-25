<?php


namespace JK\CmsBundle\Event\Subscriber;

use BlueBear\CmsBundle\Entity\Article;
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
            Events::prePersist
        ];
    }

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function prePersist(LifecycleEventArgs $event)
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
