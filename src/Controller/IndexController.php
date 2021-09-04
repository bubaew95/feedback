<?php

namespace App\Controller;

use App\Form\FeedbackFormType;
use App\Service\Captcha;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, Captcha $captcha): Response
    {
        $form = $this->createForm(FeedbackFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }

        return $this->render('index/index.html.twig', [
            'feedbackForm' => $form->createView(),
            'captcha' => $captcha->get()
        ]);
    }

}
