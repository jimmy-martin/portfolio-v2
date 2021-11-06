<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(UserRepository $userRepository, ProjectRepository $projectRepository): Response
    {
        $cache = new FilesystemAdapter();

        $me = $cache->get('my_profil', function (ItemInterface $item) use ($userRepository) {
            $item->expiresAfter(600);

            return $userRepository->find(1);
        });

        // $me = $userRepository->find(1);

        $myEmail = $this->getParameter('app.my_email');


        $projects = $cache->get('last_six_projects', function (ItemInterface $item) use ($projectRepository) {
            $item->expiresAfter(600);

            return $projectRepository->findLastSix();
        });

        // $projects = $projectRepository->findLastSix();

        // dump($me, $projects);

        return $this->render('home/home.html.twig', [
            'me' => $me,
            'projects' => $projects,
            'myEmail' => $myEmail,
        ]);
    }
}
