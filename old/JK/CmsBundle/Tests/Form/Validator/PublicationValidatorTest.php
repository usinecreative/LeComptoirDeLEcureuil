<?php

namespace JK\CmsBundle\Tests\Form\Validator;

use App\Entity\Article;
use App\Form\Constraint\Publication;
use JK\CmsBundle\Form\Validator\PublicationValidator;
use LAG\AdminBundle\Tests\AdminTestBase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilder;

class PublicationValidatorTest extends AdminTestBase
{
    public function testValidate()
    {
        $context = $this
            ->getMockBuilder(ExecutionContextInterface::class)
            ->getMock()
        ;
        $validator = new PublicationValidator();
        $validator->initialize($context);

        $constraint = new Publication();

        $this->assertExceptionRaised(\LogicException::class, function () use ($validator, $constraint) {
            $validator->validate(new \stdClass(), $constraint);
        });

        $constraintBuilder = $this
            ->getMockBuilder(ConstraintViolationBuilder::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $constraintBuilder
            ->expects($this->once())
            ->method('atPath')
            ->with('publication_date')
            ->willReturn($constraintBuilder)
        ;
        $constraintBuilder
            ->expects($this->once())
            ->method('addViolation')
        ;

        $context = $this
            ->getMockBuilder(ExecutionContextInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $context
            ->expects($this->once())
            ->method('buildViolation')
            ->willReturn($constraintBuilder)
        ;
        $article = new Article();
        $article->setPublicationStatus(Article::PUBLICATION_STATUS_PUBLISHED);

        $validator->initialize($context);
        $validator->validate($article, $constraint);
    }
}
