<?php

namespace JK\CmsBundle\Tests\Form\Validator;

use ReCaptcha\Response;

class RecaptchaTestObject
{
    public function verify($value)
    {
        return new Response($value);
    }
}
