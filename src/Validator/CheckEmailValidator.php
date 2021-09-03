<?php

namespace App\Validator;

use App\Service\EmailFilter;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckEmailValidator extends ConstraintValidator
{
    /**
     * @var EmailFilter $emailFilter
     */
    private EmailFilter $emailFilter;

    public function __construct(EmailFilter $emailFilter)
    {
        $this->emailFilter = $emailFilter;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\CheckEmail */

        if (null === $value || '' === $value) {
            return;
        }

        if($this->emailFilter->filter($value)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
