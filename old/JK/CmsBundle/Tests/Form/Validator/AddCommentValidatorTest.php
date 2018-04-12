<?php

namespace JK\CmsBundle\Tests\Form\Validator;

use App\Entity\Comment;
use JK\CmsBundle\Form\Constraint\AddComment;
use JK\CmsBundle\Form\Validator\AddCommentValidator;
use LAG\AdminBundle\Tests\AdminTestBase;
use stdClass;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilder;

class AddCommentValidatorTest extends AdminTestBase
{
    public function testValidate()
    {
        $context = $this
            ->getMockBuilder(ExecutionContextInterface::class)
            ->getMock()
        ;
        $context
            ->expects($this->never())
            ->method('addViolation');

        $validator = new AddCommentValidator();
        $validator->initialize($context);

        $comment = new Comment();
        $constraint = new AddComment();

        // if the given object is not a Comment, an exception SHOULD be raised
        $this->assertExceptionRaised(\Exception::class, function () use ($validator, $constraint) {
            $validator->validate(new stdClass(), $constraint);
        });

        // with an empty Comment, no violations should be build
        $validator->validate($comment, $constraint);

        $context = $this
            ->getMockBuilder(ExecutionContextInterface::class)
            ->getMock()
        ;
        $context
            ->method('buildViolation')
            ->willReturnCallback(function () {
                $builder = $this
                    ->getMockBuilder(ConstraintViolationBuilder::class)
                    ->disableOriginalConstructor()
                    ->getMock()
                ;
                $builder
                    ->method('atPath')
                    ->willReturnCallback(function () {
                        $builder = $this
                            ->getMockBuilder(ConstraintViolationBuilder::class)
                            ->disableOriginalConstructor()
                            ->getMock()
                        ;
                        $builder
                            ->expects($this->once())
                            ->method('addViolation')
                        ;

                        return $builder;
                    });

                return $builder;
            });
        $comment->setNotifyNewComments(true);

        $validator->initialize($context);
        $validator->validate($comment, $constraint);
    }
}
