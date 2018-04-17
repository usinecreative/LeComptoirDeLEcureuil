<?php

namespace JK\CmsBundle\Tests\Form\Constraint;

use App\Form\Constraint\AddComment;
use JK\CmsBundle\Form\Validator\AddCommentValidator;
use LAG\AdminBundle\Tests\AdminTestBase;
use Symfony\Component\Validator\Constraint;

class AddCommentTest extends AdminTestBase
{
    public function testValidatedBy()
    {
        $constraint = new AddComment();
        $this->assertEquals(AddCommentValidator::class, $constraint->validatedBy());
    }

    public function testGetTargets()
    {
        $constraint = new AddComment();
        $this->assertEquals(Constraint::CLASS_CONSTRAINT, $constraint->getTargets());
    }
}
