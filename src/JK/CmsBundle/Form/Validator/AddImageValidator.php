<?php

namespace JK\CmsBundle\Form\Validator;

use BlueBear\CmsBundle\Entity\Comment;
use Exception;
use JK\CmsBundle\Form\Type\AddImageType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class AddImageValidator implements ConstraintValidatorInterface
{
    /**
     * @var ExecutionContextInterface
     */
    protected $context;

    /**
     * Initializes the constraint validator.
     *
     * @param ExecutionContextInterface $context The current validation context
     */
    public function initialize(ExecutionContextInterface $context)
    {
        $this->context = $context;
    }
    
    public function validate($data, Constraint $constraint)
    {
        if ($data['uploadType'] === AddImageType::UPLOAD_FROM_COMPUTER) {
    
            if (!$data['upload']) {
                $this
                    ->context
                    ->buildViolation('cms.media.violations.empty_upload_from_computer')
                    ->atPath('upload')
                    ->addViolation()
                ;
            }
        }
    }
}
