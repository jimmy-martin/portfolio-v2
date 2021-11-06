<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portfolio", name="portfolio_")
 */
class PortfolioController extends AbstractController
{
    /**
     * @Route("", name="browse")
     */
    public function browse(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();

        return $this->render('portfolio/browse.html.twig', [
            'projects' => $projects,
        ]);
    }
}
