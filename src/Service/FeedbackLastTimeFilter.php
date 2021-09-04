<?php

namespace App\Service;

use App\Entity\Feedback;

class FeedbackLastTimeFilter implements FeedbackLastTimeFilterInterface
{
    /**
     * @param Feedback $feedback
     * @return bool
     */
    public function filter(Feedback $feedback) : bool
    {
        /**
         * @var \DateTime $lastFeedbackLastSendTime
         */
        $lastFeedbackLastSendTime = $feedback->getCreatedAt();
        $lastFeedbackLastSendTime->add(new \DateInterval('PT2M'));

        $date = new \DateTime();

        if($lastFeedbackLastSendTime->getTimestamp() < $date->getTimestamp()) {
            return true;
        }
        return false;
    }
}