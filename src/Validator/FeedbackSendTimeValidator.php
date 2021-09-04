<?php

namespace App\Validator;

use App\Entity\Feedback;
use App\Repository\FeedbackRepository;
use App\Service\FeedbackLastTimeFilter;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FeedbackSendTimeValidator extends ConstraintValidator
{
    /**
     * @var FeedbackRepository $feedbackRepository
     */
    private FeedbackRepository $feedbackRepository;

    /**
     * @var FeedbackLastTimeFilter $lastTimeFilter
     */
    private FeedbackLastTimeFilter $lastTimeFilter;

    public function __construct(
        FeedbackRepository $feedbackRepository,
        FeedbackLastTimeFilter $lastTimeFilter
    )
    {
        $this->feedbackRepository = $feedbackRepository;
        $this->lastTimeFilter = $lastTimeFilter;
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

        if($lastFeedback && $this->lastTimeFilter->filter($lastFeedback)) {
            return;
        }

        /**
         * @var Feedback $lastFeedback
         */
        $lastFeedbackIp = $this->feedbackRepository->findByLastSendFormIp($_SERVER['REMOTE_ADDR']);

        if($this->lastTimeFilter->filter($lastFeedbackIp)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
