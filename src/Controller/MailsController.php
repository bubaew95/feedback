<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Repository\FeedbackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailsController extends AbstractController
{
    /**
     * @Route("/mail", name="app_mail")
     */
    public function shw(FeedbackRepository $feedbackRepository, Request $request)
    {
        /**
         * @var Feedback $lastFeedback
         */
        $lastFeedback = $feedbackRepository->findByLastSendForm($request->get('email'));


        dd($lastFeedback);
    }

    /**
     * @Route("/mails/{id}", name="app_mails")
     */
    public function index(Request $request, FeedbackRepository $fbRepository): Response
    {
        $feedback = $fbRepository->findBy(['user' => $request->get('id')]);

        return $this->render('mails/index.html.twig', [
            'feedback' => $feedback,
        ]);
    }
}
