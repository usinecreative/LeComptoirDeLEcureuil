<?php

namespace JK\CmsBundle\Tests\Form\Validator;

use JK\CmsBundle\Form\Validator\RecaptchaValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RecaptchaValidatorTestObject extends RecaptchaValidator
{
    public function __construct($secret, RequestStack $requestStack, $reCaptchaResponse)
    {
        parent::__construct($secret, $requestStack);

        $this->recaptcha = new RecaptchaTestObject();
        $this->request = new Request([
            'g-recaptcha-response' => $reCaptchaResponse,
        ]);
    }
}
