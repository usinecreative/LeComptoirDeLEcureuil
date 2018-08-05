<?php

namespace App\Controller\Cms;

use App\Repository\CommentRepository;
use LAG\AdminBundle\Event\AdminEvents;
use LAG\AdminBundle\Event\MenuEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DashboardAction
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * DashboardAction constructor.
     *
     * @param TokenStorageInterface    $tokenStorage
     * @param CommentRepository        $commentRepository
     * @param \Twig_Environment        $twig
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        CommentRepository $commentRepository,
        \Twig_Environment $twig,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->commentRepository = $commentRepository;
        $this->twig = $twig;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke()
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $this->eventDispatcher->dispatch(AdminEvents::MENU, new MenuEvent());

        $newCommentCount = $this
            ->commentRepository
            ->findNewCommentCount($user->getCommentLastViewDate())
        ;
        $content = $this->twig->render('Cms/Dashboard/dashboard.html.twig', [
            'newCommentCount' => $newCommentCount,
        ]);

        return new Response($content);
    }
}
