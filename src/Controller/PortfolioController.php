<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\ItemInterface;

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
        $cache = new FilesystemAdapter();

        $projects = $cache->get('all_projects', function(ItemInterface $item) use ($projectRepository) {
            $item->expiresAfter(600);

            return $projectRepository->findAll();
        });

        // $projects = $projectRepository->findAll();

        return $this->render('portfolio/browse.html.twig', [
            'projects' => $projects,
        ]);
    }
}
