<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Entity\User;
use App\Form\FeedbackFormType;
use App\Form\Model\FeedbackFormModel;
use App\Repository\UserRepository;
use App\Service\Captcha;
use App\Service\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(
        Request $request,
        Captcha $captcha,
        EntityManagerInterface $em,
        UserRepository $userRepository,
        Mailer $mailer
    ): Response
    {
        $form = $this->createForm(FeedbackFormType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            /**
             * @var FeedbackFormModel $model;
             */
            $model = $form->getData();
            if($userId = $this->handleFormRequest($model, $userRepository, $em)) {
                $mailer->sendMailUser($model);
                $mailer->sendMailAdmin($model, $userId);
                $this->addFlash('flash_message', 'Форма успешно отправлена');
            }
            return $this->redirectToRoute('app_index');
        }

        return $this->render('index/index.html.twig', [
            'feedbackForm' => $form->createView(),
            'captcha' => $captcha->get()
        ]);
    }


    /**
     * @param FeedbackFormModel $model
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $em
     * @return int|null
     */
    private function handleFormRequest(
        FeedbackFormModel $model,
        UserRepository  $userRepository,
        EntityManagerInterface $em
    ) : ?int
    {
        $user = $userRepository->findBydEmail($model->email) ?? $this->addUser($model, $em);
        $feed = $this->addFeedBack($model, $user, $em);
        $em->flush();
        return $feed ? $user->getId() : null;
    }

    /**
     * @param FeedbackFormModel $model
     * @param EntityManagerInterface $em
     * @return User
     */
    private function addUser(FeedbackFormModel $model, EntityManagerInterface $em) : User
    {
        $user = new User();
        $user
            ->setName($model->name)
            ->setEmail($model->email)
        ;
        $em->persist($user);
        return $user;
    }

    /**
     * @param FeedbackFormModel $model
     * @param User $user
     * @param EntityManagerInterface $em
     * @return Feedback
     */
    private function addFeedBack(
        FeedbackFormModel $model,
        User $user,
        EntityManagerInterface $em
    ) : Feedback
    {
        $feedback = new Feedback($user, $model->message);
        $em->persist($feedback);
        return $feedback;
    }

}
