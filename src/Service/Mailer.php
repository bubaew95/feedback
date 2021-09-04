<?php

namespace App\Service;

use App\Form\Model\FeedbackFormModel;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\MailerInterface as ServiceMailerInterface;
use Symfony\Component\Mime\Address;

class Mailer implements ServiceMailerInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param FeedbackFormModel $model
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendMailUser(FeedbackFormModel $model)
    {
        $mail = $this->templatedEmail()
            ->to(new Address('info@awardwallet.com', 'AwardWallet'))
            ->htmlTemplate('email/feedback-user.html.twig')
            ->context([
                'feedback' => $model
            ])
        ;
        return $this->mailer->send($mail);
    }

    /**
     * @param FeedbackFormModel $model
     * @param int|null $userId
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function sendMailAdmin(FeedbackFormModel $model, ?int $userId)
    {
        $mail = $this->templatedEmail()
            ->to(new Address('info@awardwallet.com', 'AwardWallet'))
            ->htmlTemplate('email/feedback-admin.html.twig')
            ->context([
                'feedback' => $model,
                'userId' => $userId
            ])
        ;
        return $this->mailer->send($mail);
    }

    /**
     * @return TemplatedEmail
     */
    private function templatedEmail() : TemplatedEmail
    {
        return (new TemplatedEmail())
            ->from(new Address('support@mysite.com', 'MySite'));
    }

}