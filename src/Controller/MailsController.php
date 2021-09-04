<?php

namespace App\Controller;

use App\Repository\FeedbackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailsController extends AbstractController
{
    /**
     * @Route("/mails/{id}", name="app_mails")
     */
    public function index(Request $request, FeedbackRepository $fbRepository): Response
    {
        $feedback = $fbRepository->findBy(['user' => (int) $request->get('id')]);

        return $this->render('mails/index.html.twig', [
            'messages' => $feedback,
        ]);
    }
}
