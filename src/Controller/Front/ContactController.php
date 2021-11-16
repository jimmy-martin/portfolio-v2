<?php

namespace App\Controller\Front;

use App\Form\ContactType;
use App\Repository\UserRepository;
use App\Service\EmailSender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact", name="front_contact_")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("", name="browse")
     */
    public function browse(UserRepository $userRepository, Request $request, EmailSender $emailSender): Response
    {
        $user = $userRepository->findOneBy(
            ['firstname' => 'Jimmy'],
        );

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());

            $datas = $form->getData();

            $isEmailSend = $emailSender->sendStandard(
                $datas['email'],
                $user->getEmail(),
                $datas['message'],
                $datas['subject']
            );

            if ($isEmailSend === true) {
                $this->addFlash('success', 'Votre email a bien été envoyé.');

                $emailSender->sendTemplatedEmail(
                    $user->getEmail(),
                    $datas['email'],
                    [
                        'sender' => $datas['name'],
                    ],
                    'Confirmation email Portfolio de Jimmy MARTIN'
                );

            } else {
                $this->addFlash('danger', 'Une erreur s\'est produite, veuillez réessayer.');
            }

            return $this->redirectToRoute('front_contact_browse');
        }

        return $this->render('front/contact/browse.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
