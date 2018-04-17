<?php

namespace JK\CmsBundle\Tests\Form\Type;

use App\Entity\Comment;
use App\Entity\Article;
use JK\CmsBundle\Form\Type\AddCommentType;
use JK\CmsBundle\Form\Type\RecaptchaType;
use App\Repository\ArticleRepository;
use PHPUnit_Framework_MockObject_MockObject;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

class AddCommentTypeTest extends TypeTestCase
{
    public function testSubmittedData()
    {
        $article = new Article();
        $article->setId(42);
        $comment = new Comment();
        $comment->setArticle($article);
        $form = $this
            ->factory
            ->create(AddCommentType::class, $comment);

        $data = [
            'authorName' => 'John The Panda',
            'authorUrl' => 'my.blog.fr',
            'content' => 'MY MESSAGE ! $ù**ù^',
            'article' => 42,
            'notifyNewComments' => false,
            'recaptcha' => null,
        ];
        $form->submit($data);

        $this->assertTrue($form->isSubmitted());
        $this->assertTrue($form->isSynchronized());
        $this->assertFalse($form->isEmpty());
        $this->assertInstanceOf(Comment::class, $form->getData());
        $this->assertEquals('John The Panda', $form->getData()->getAuthorName());
        $this->assertEquals('my.blog.fr', $form->getData()->getAuthorUrl());
        $this->assertEquals('MY MESSAGE ! $ù**ù^', $form->getData()->getContent());
        $this->assertEquals(42, $form->getData()->getArticle()->getId());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($data) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    protected function getExtensions()
    {
        $article = new Article();
        $article->setId(42);
        /** @var ArticleRepository|PHPUnit_Framework_MockObject_MockObject $repository */
        $repository = $this
            ->getMockBuilder(ArticleRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $repository
            ->expects($this->once())
            ->method('find')
            ->with(42)
            ->willReturn($article);
        $addCommentType = new AddCommentType($repository);
        $recaptchaType = new RecaptchaType('my-site-key');

        return [
            new PreloadedExtension([
                $addCommentType,
                $recaptchaType,
            ], []),
        ];
    }
}
