<?php

namespace App\Controller\Cms;

use App\Exception\Exception;
use App\Form\Type\LoginType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginAction
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * LoginAction constructor.
     *
     * @param TokenStorageInterface         $tokenStorage
     * @param RouterInterface               $router
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param AuthenticationUtils           $authenticationUtils
     * @param FormFactoryInterface          $formFactory
     * @param \Twig_Environment             $twig
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        RouterInterface $router,
        AuthorizationCheckerInterface $authorizationChecker,
        AuthenticationUtils $authenticationUtils,
        FormFactoryInterface $formFactory,
        \Twig_Environment $twig
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
        $this->authenticationUtils = $authenticationUtils;
        $this->formFactory = $formFactory;
        $this->twig = $twig;
    }

    /**
     * @return RedirectResponse|Response
     */
    public function loginAction()
    {
        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            throw new AccessDeniedException();
        }
        $user = $token->getUser();
        $isGranted = $this->authorizationChecker->isGranted([
            'ROLE_ADMIN'
        ], $user);

        if ($isGranted) {
            return new RedirectResponse($this->router->generate('lecomptoir.cms.homepage'));
        }
        $exception = $this
            ->authenticationUtils
            ->getLastAuthenticationError();
        $error = $exception ? $exception->getMessage() : null;
        $form = $this->formFactory->create(LoginType::class);

        $content =$this->twig->render('@BlueBearCms/Guard/login.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);

        return new Response($content);
    }

    /**
     * @throws Exception
     */
    public function loginCheckAction()
    {
        // will never be executed
        throw new Exception();
    }
}
