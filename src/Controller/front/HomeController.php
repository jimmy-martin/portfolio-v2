<?php

namespace App\Front\Controller;

use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(UserRepository $userRepository, ProjectRepository $projectRepository): Response
    {
        $me = $userRepository->find(1);

        $myEmail = $this->getParameter('app.my_email');

        $projects = $projectRepository->findLastSix();

        // dump($me, $projects);

        return $this->render('front/home/home.html.twig', [
            'me' => $me,
            'projects' => $projects,
            'myEmail' => $myEmail,
        ]);
    }
}
