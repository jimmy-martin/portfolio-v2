<?php

namespace App\Controller;

use App\Form\ContactType;
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
    public function browse(): Response
    {
        $form = $this->createForm(ContactType::class);

        return $this->render('contact/browse.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
