<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact", name="contact_")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("", name="browse")
     */
    public function browse(UserRepository $userRepository): Response
    {
        $me = $userRepository->find(1);

        $form = $this->createForm(ContactType::class);

        return $this->render('contact/browse.html.twig', [
            'form' => $form->createView(),
            'me' => $me,
        ]);
    }
}
