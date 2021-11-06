<?php

namespace App\Controller;

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
        return $this->render('contact/browse.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
