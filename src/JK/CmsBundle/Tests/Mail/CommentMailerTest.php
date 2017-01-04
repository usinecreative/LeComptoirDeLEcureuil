<?php

namespace JK\CmsBundle\Tests\Mail;

use BlueBear\CmsBundle\Entity\Comment;
use BlueBear\CmsBundle\Repository\CommentRepository;
use Exception;
use JK\CmsBundle\Entity\Article;
use JK\CmsBundle\Mail\CommentMailer;
use LAG\AdminBundle\Tests\AdminTestBase;
use Swift_Mailer;
use Twig_Environment;

class CommentMailerTest extends AdminTestBase
{
    public function testSendNewCommentMail()
    {
        $swiftMailer = $this
            ->getMockBuilder(Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();
        $repository = $this
            ->getMockBuilder(CommentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('findShouldBeNotified')
            ->willReturnCallback(function(Comment $comment) {
                $comment1 = new Comment();
    
                return [
                    $comment1,
                ];
            });
        
        $twig = $this
            ->getMockBuilder(Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();
    
        $comment = new Comment();
        
        $mailer = new CommentMailer($swiftMailer, $repository, $twig, 'test@test.fr');
    
        // an exception should be raised if the Comment has no Article
        $this->assertExceptionRaised(Exception::class, function() use ($mailer, $comment) {
            $mailer->sendNewCommentMail($comment);
        });
    
        $article = new Article();
        $article->setTitle('My Article');
        $comment->setArticle($article);
    
        $mailer->sendNewCommentMail($comment);
    }
}
