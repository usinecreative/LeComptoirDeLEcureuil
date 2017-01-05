<?php

namespace JK\CmsBundle\Tests\Form\Constraint;

use JK\CmsBundle\Form\Constraint\Recaptcha;
use JK\CmsBundle\Form\Validator\RecaptchaValidator;
use LAG\AdminBundle\Tests\AdminTestBase;
use Symfony\Component\Validator\Constraint;

class RecaptchaTest extends AdminTestBase
{
    public function testValidatedBy()
    {
        $constraint = new Recaptcha();
        $this->assertEquals(RecaptchaValidator::class, $constraint->validatedBy());
    }

    public function testGetTargets()
    {
        $constraint = new Recaptcha();
        $this->assertNotEquals(Constraint::CLASS_CONSTRAINT, $constraint->getTargets());
    }
}
