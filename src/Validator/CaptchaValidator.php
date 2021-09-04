<?php

namespace App\Validator;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CaptchaValidator extends ConstraintValidator
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\Captcha */

        if (null === $value || '' === $value) {
            return;
        }

        if((int) $this->session->get('captcha') === (int) $value) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
