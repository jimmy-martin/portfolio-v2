<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SoftwareController extends AbstractController
{
    /**
     * @Route("/back/software", name="back_software")
     */
    public function index(): Response
    {
        return $this->render('back/software/index.html.twig', [
            'controller_name' => 'SoftwareController',
        ]);
    }
}
