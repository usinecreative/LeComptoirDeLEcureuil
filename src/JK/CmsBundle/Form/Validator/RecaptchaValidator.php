<?php

namespace JK\CmsBundle\Form\Validator;

use ReCaptcha\ReCaptcha;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Validate a recaptcha field.
 */
class RecaptchaValidator extends ConstraintValidator
{
    /**
     * @var ReCaptcha
     */
    protected $recaptcha;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var ExecutionContextInterface
     */
    protected $context;

    /**
     * RecaptchaValidator constructor.
     *
     * @param string       $secret
     * @param RequestStack $requestStack
     */
    public function __construct($secret, RequestStack $requestStack)
    {
        $this->recaptcha = new ReCaptcha($secret);
        $this->request = $requestStack->getMasterRequest();
    }

    /**
     * Initializes the constraint validator.
     *
     * @param ExecutionContextInterface $context The current validation context
     */
    public function initialize(ExecutionContextInterface $context)
    {
        $this->context = $context;
    }

    /**
     * Check if the recaptcha is valid.
     *
     * @param string     $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        $value = $this
            ->request
            ->get('g-recaptcha-response');

        // verify the captcha
        $result = $this
            ->recaptcha
            ->verify($value, $this->request->getClientIp());

        // if the recaptcha is not valid, we add a violation
        if (!$result->isSuccess()) {
            $this
                ->context
                ->buildViolation('cms.comment.violations.recaptcha')
                ->atPath('recaptcha')
                ->addViolation()
            ;
        }
    }
}
