<?php

namespace App\Service;

use App\Entity\Feedback;

interface FeedbackLastTimeFilterInterface
{
    /**
     * @param Feedback $feedback
     * @return bool
     */
    public function filter(Feedback $feedback) : bool;
}