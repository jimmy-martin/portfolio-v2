<?php

namespace App\Controller\Front;

use App\Form\ContactType;
use App\Repository\UserRepository;
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
    public function browse(UserRepository $userRepository, Request $request, MailerInterface $mailer): Response
    {
        $user = $userRepository->find(1);

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());

            $datas = $form->getData();


            $email = (new Email())
                ->from($datas['email'])
                ->to($userRepository->find(1)->getEmail())
                ->subject($datas['subject'])
                ->text('De la part de ' . $datas['name'] . ' : ' . $datas['message']);

            $mailer->send($email);

            $this->addFlash('success', 'Votre email a bien été envoyé.');

            return $this->redirectToRoute('contact_browse');
        }

        return $this->render('front/contact/browse.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
