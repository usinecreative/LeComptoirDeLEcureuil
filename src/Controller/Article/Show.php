<?php

namespace App\Controller\Article;

use App\Entity\Article;
use App\Factory\CommentFactory;
use App\Form\Type\AddCommentType;
use App\Mailer\Mailer;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig_Environment;

class Show
{
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var CommentFactory
     */
    private $commentFactory;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(
        Twig_Environment $twig,
        ArticleRepository $articleRepository,
        CommentRepository $commentRepository,
        CommentFactory $commentFactory,
        FormFactoryInterface $formFactory,
        Mailer $mailer
    ) {
        $this->twig = $twig;
        $this->articleRepository = $articleRepository;
        $this->commentFactory = $commentFactory;
        $this->formFactory = $formFactory;
        $this->commentRepository = $commentRepository;
        $this->mailer = $mailer;
    }

    public function __invoke(Request $request): Response
    {
        /** @var Article $article */
        $article = $this->articleRepository->findOneBy([
            'slug' => $request->get('slug'),
            'publicationStatus' => Article::PUBLICATION_STATUS_PUBLISHED,
        ]);

        if (null === $article) {
            throw new NotFoundHttpException();
        }
        $comment = $this->commentFactory->create($article);
        $form = $this->formFactory->create(AddCommentType::class, $comment);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commentRepository->save($comment);
            $this->mailer->sendNewCommentMail($comment);
        }
        $content = $this->twig->render('Article/show.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView(),
        ]);

        return new Response($content);
    }
}
