<?php

namespace App\Service;

use App\Form\Model\FeedbackFormModel;

interface MailerInterface
{
    /**
     * @param FeedbackFormModel $model
     * @return mixed
     */
    public function sendMailUser(FeedbackFormModel $model);

    /**
     * @param FeedbackFormModel $model
     * @param int|null $userId
     * @return mixed
     */
    public function sendMailAdmin(FeedbackFormModel $model, ?int $userId);

}