<?php

namespace App\JK\CmsBundle\Form\Constraint;

use App\JK\CmsBundle\Form\Validator\RecaptchaValidator;
use Symfony\Component\Validator\Constraint;

class Recaptcha extends Constraint
{
    public $message = 'Only humans can post on this form';

    public function validatedBy()
    {
        return RecaptchaValidator::class;
    }
}
