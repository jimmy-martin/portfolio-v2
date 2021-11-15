<?php

namespace App\Controller\Front;

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
        $user = $userRepository->findOneBy(
            ['firstname' => 'Jimmy'],
        );

        $projects = $projectRepository->findLastSix();

        // dump($user, $projects);

        return $this->render('front/home/home.html.twig', [
            'user' => $user,
            'projects' => $projects,
        ]);
    }
}
