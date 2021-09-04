<?php

namespace App\Validator;

use App\Entity\Feedback;
use App\Repository\FeedbackRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FeedbackSendTimeValidator extends ConstraintValidator
{
    private FeedbackRepository $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\FeedbackSendTime */

        if (null === $value || '' === $value) {
            return;
        }

        /**
         * @var Feedback $lastFeedback
         */
        $lastFeedback = $this->feedbackRepository->findByLastSendForm($value);

        /**
         * @var \DateTime $lastFeedbackLastSendTime
         */
        $lastFeedbackLastSendTime = $lastFeedback->getCreatedAt();
        $lastFeedbackLastSendTime->add(new \DateInterval('PT2M'));

        $date = new \DateTime();

        if($lastFeedbackLastSendTime->getTimestamp() < $date->getTimestamp()) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
