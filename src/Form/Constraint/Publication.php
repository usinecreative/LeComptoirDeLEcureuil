<?php

namespace App\Form\Constraint;

use App\Form\Validator\PublicationValidator;
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
