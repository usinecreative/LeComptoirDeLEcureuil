<?php

namespace AppBundle\Form\Handler;


use BlueBear\CmsBundle\Entity\Comment;
use BlueBear\CmsBundle\Repository\CommentRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class CommentHandler
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function handle(FormInterface $form, Request $request)
    {
        $data = $form->getData();

        $comment = new Comment();
        $comment->setArticle($data['article']);
        $comment->setAuthorIp($request->getClientIp());
        $comment->setAuthorName($data['authorName']);

        $this
            ->commentRepository
            ->save($comment);
    }
}
