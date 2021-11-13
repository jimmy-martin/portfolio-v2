<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OperatingSystemController extends AbstractController
{
    /**
     * @Route("/back/operating/system", name="back_operating_system")
     */
    public function index(): Response
    {
        return $this->render('back/operating_system/index.html.twig', [
            'controller_name' => 'OperatingSystemController',
        ]);
    }
}
