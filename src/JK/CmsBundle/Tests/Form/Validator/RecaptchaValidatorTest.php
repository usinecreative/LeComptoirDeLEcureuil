<?php

namespace JK\CmsBundle\Tests\Form\Validator;

use JK\CmsBundle\Form\Constraint\Recaptcha;
use LAG\AdminBundle\Tests\AdminTestBase;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilder;

class RecaptchaValidatorTest extends AdminTestBase
{
    public function testValidate()
    {
        $requestStack = $this
            ->getMockBuilder(RequestStack::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $constraint = new Recaptcha();
        $context = $this
            ->getMockBuilder(ExecutionContextInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $validator = new RecaptchaValidatorTestObject('my-secret', $requestStack, true);
        $validator->initialize($context);
        $validator->validate(true, $constraint);
    
        $validator = new RecaptchaValidatorTestObject('my-secret', $requestStack, false);
        $context = $this->getMock(ExecutionContextInterface::class);
        $context
            ->method('buildViolation')
            ->willReturnCallback(function() {
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
        $validator->initialize($context);
        $validator->validate(false, $constraint);
    }
}
