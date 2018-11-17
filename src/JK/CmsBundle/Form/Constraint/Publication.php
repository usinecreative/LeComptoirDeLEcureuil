<?php

namespace App\JK\CmsBundle\Form\Constraint;

use App\JK\CmsBundle\Form\Validator\PublicationValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation()
 */
class Publication extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy()
    {
        return PublicationValidator::class;
    }

    /**
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
