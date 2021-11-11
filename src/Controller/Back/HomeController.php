<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/admin/", name="back_home")
     */
    public function browse(): Response
    {
        return $this->render('back/home/browse.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
