<?php

namespace App\Controller\Back;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/project", name="back_project_")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("", name="browse")
     */
    public function browse(ProjectRepository $projectRepository): Response
    {
        return $this->render('back/project/browse.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="read")
     */
    public function read(Project $project): Response
    {
        return $this->render('back/project/read.html.twig', [
            'project' => $project,
        ]);
    }
}
