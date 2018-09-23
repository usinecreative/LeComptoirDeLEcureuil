<?php

namespace App\Controller\Cms;

use App\Repository\CategoryRepository;
use LAG\AdminBundle\Event\AdminEvents;
use LAG\AdminBundle\Event\MenuEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class HomepageAction
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * HomepageAction constructor.
     *
     * @param Twig_Environment         $twig
     * @param CategoryRepository       $categoryRepository
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        Twig_Environment $twig,
        CategoryRepository $categoryRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->twig = $twig;
        $this->categoryRepository = $categoryRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return Response
     */
    public function __invoke()
    {
        $this->eventDispatcher->dispatch(AdminEvents::MENU, new MenuEvent());

        $categories = $this
            ->categoryRepository
            ->findAll()
        ;
        $content = $this
            ->twig
            ->render('Cms/homepage.html.twig', [
                'categories' => $categories,
            ])
        ;

        return new Response($content);
    }
}
