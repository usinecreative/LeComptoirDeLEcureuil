<?php

namespace BlueBear\CmsBundle\Event\Subscriber;

use BlueBear\CmsBundle\Cms\Factory\ContentTypeFactory;
use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig_Environment;

class KernelSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }

    /**
     * @var TwigEngine
     */
    protected $twig;

    /**
     * @var ContentTypeFactory
     */
    protected $contentTypeFactory;

    protected $contentTypeConfiguration;

    /**
     * @param Twig_Environment $twigEngine
     * @param ContentTypeFactory $contentTypeFactory
     * @param array $contentTypeConfiguration
     */
    public function __construct(Twig_Environment $twigEngine, ContentTypeFactory $contentTypeFactory, array $contentTypeConfiguration)
    {
        $this->twig = $twigEngine;
        $this->contentTypeFactory = $contentTypeFactory;
        $this->contentTypeConfiguration = $contentTypeConfiguration;
    }

    public function onKernelController(KernelEvent $event)
    {
        if ($event->getRequestType() == HttpKernelInterface::MASTER_REQUEST) {
            $this->contentTypeFactory->create($this->contentTypeConfiguration);
        }

    }
}