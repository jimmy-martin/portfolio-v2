<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact", name="contact_")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("", name="browse")
     */
    public function browse(UserRepository $userRepository, Request $request, MailerInterface $mailer): Response
    {
        $me = $userRepository->find(1);

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        $myEmail = $this->getParameter('app.my_email');

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());

            $datas = $form->getData();


            $email = (new Email())
                ->from($datas['email'])
                ->to($myEmail)
                ->subject($datas['subject'])
                ->text('De la part de ' . $datas['name'] . ' : ' . $datas['message']);

            $mailer->send($email);

            $this->addFlash('success', 'Votre email a bien été envoyé.');

            return $this->redirectToRoute('contact_browse');
        }

        return $this->render('front/contact/browse.html.twig', [
            'form' => $form->createView(),
            'me' => $me,
            'myEmail' => $myEmail,
        ]);
    }
}
