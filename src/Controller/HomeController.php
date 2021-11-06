<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(UserRepository $userRepository): Response
    {
        $me = $userRepository->find(1);

        dump($me);

        return $this->render('home/home.html.twig', [
            'me' => $me,
        ]);
    }
}
