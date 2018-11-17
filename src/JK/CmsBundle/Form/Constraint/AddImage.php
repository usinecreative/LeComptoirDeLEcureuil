<?php

namespace App\JK\CmsBundle\Form\Constraint;

use App\JK\CmsBundle\Form\Validator\AddImageValidator;
use Symfony\Component\Validator\Constraint;

class AddImage extends Constraint
{
    public function validatedBy()
    {
        return AddImageValidator::class;
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
