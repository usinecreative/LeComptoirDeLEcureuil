<?php

namespace JK\CmsBundle\Mail;

use BlueBear\CmsBundle\Entity\Comment;
use BlueBear\CmsBundle\Repository\CommentRepository;
use Exception;
use Swift_Mailer;
use Swift_Message;
use Twig_Environment;

class CommentMailer
{
    /**
     * @var Swift_Mailer
     */
    private $swiftMailer;
    
    /**
     * @var CommentRepository
     */
    private $commentRepository;
    
    /**
     * @var Twig_Environment
     */
    private $twig;
    
    /**
     * @var string
     */
    private $squirrelMail;
    
    /**
     * CommentMailer constructor.
     *
     * @param Swift_Mailer $swiftMailer
     * @param CommentRepository $commentRepository
     * @param Twig_Environment $twig
     * @param $squirrelMail
     */
    public function __construct(
        Swift_Mailer $swiftMailer,
        CommentRepository $commentRepository,
        Twig_Environment $twig,
        $squirrelMail
    ) {
        $this->swiftMailer = $swiftMailer;
        $this->commentRepository = $commentRepository;
        $this->twig = $twig;
        $this->squirrelMail = $squirrelMail;
    }
    
    /**
     * Send a new mail to notify on a new Comment.
     *
     * @param Comment $newComment
     *
     * @throws Exception
     */
    public function sendNewCommentMail(Comment $newComment)
    {
        if (null === $newComment->getArticle()) {
            throw new Exception('Your Comment should be related to an Article to send mails');
        }
        // find all comments with this email in the same Article than the new Comment
        $comments = $this
            ->commentRepository
            ->findShouldBeNotified($newComment);
        $messages = [];
        $subject = sprintf(
            "[LeComptoirDeLEcureuil] Un nouveau commentaire a été publié sur l'article %s",
            $newComment->getArticle()->getTitle()
        );
    
        foreach ($comments as $comment) {
            $body = $this
                ->twig
                ->render('@JKCms/Mail/newCommentNotification.html.twig', [
                    'newComment' => $newComment,
                    'comment' => $comment,
                    'authorName' => $comment->getAuthorName(),
                ]);
            // create Message instance
            $message = $this->createMessage(
                $subject,
                $body,
                'noisette@lecomptoirdelecureuil.fr',
                $comment->getAuthorEmail()
            );
    
            // avoid duplicated mail
            $messages[$comment->getAuthorEmail()] = $message;
        }
        // add a message to the administrator
        $body = $this
            ->twig
            ->render('@JKCms/Mail/newCommentNotification.html.twig', [
                'newComment' => $newComment,
                'authorName' => 'Ecureuil'
            ]);
        $message = $this->createMessage($subject, $body, 'noisette@lecomptoirdelecureuil.fr', $this->squirrelMail);
        $messages[$this->squirrelMail] = $message;
        
        foreach ($messages as $message) {
            // actually send the mail
            $this
                ->swiftMailer
                ->send($message);
        }
    }
    
    protected function createMessage($subject, $body, $from, $to)
    {
        return Swift_Message::newInstance($subject, $body, 'text/html', 'utf8')
            ->setFrom($from)
            ->setTo($to);
    }
}
