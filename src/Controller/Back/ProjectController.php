<?php

namespace App\Controller\Back;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/project", name="back_project_", requirements={"id"="\d+"})
 */
class ProjectController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

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

    /**
     * @Route("/add", name="add")
     */
    public function add(FileUploader $fileUploader, Request $request)
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $fileUploader->uploadProjectImage($form);

            $this->manager->persist($project);
            $this->manager->flush();

            $this->addFlash('success', 'Le projet a bien été ajouté');

            return $this->redirectToRoute('back_project_browse');
        }

        return $this->render('back/project/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(FileUploader $fileUploader, Request $request, Project $project)
    {
        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('image')->getData()) {
                $fileUploader->uploadProjectImage($form);
            }

            $project->setUpdatedAt(new \DateTime());
            $this->manager->flush();

            $this->addFlash('success', 'Le projet a bien été modifié');

            return $this->redirectToRoute('back_project_browse');
        }

        return $this->render('back/project/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Project $project)
    {
        $submittedAntiCSRFToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete_project' . $project->getId(), $submittedAntiCSRFToken)) {
            $this->manager->remove($project);
            $this->manager->flush();

            $this->addFlash('success', 'Le projet a bien été supprimé');

            return $this->redirectToRoute('back_project_browse');
        }

        $this->addFlash('danger', 'Une erreur est survenue lors de la suppression');

        return $this->redirectToRoute('back_project_browse');
    }

    /**
     * @Route("/homepage/toggle/{id}", name="homepage_toggle")
     */
    public function toggleToHomePage(Project $project, Request $request)
    {
        $submittedAntiCSRFToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('homepage_add_project' . $project->getId(), $submittedAntiCSRFToken)) {
            $project->setOnHome(!$project->getOnHome());
            $this->manager->flush();

            $this->addFlash('success', 'Le projet a bien été ajouté sur la page d\'accueil');

            return $this->redirectToRoute('back_project_browse');
        }

        $this->addFlash('danger', 'Une erreur est survenue lors de l\'ajout sur la page d\'accueil');

        return $this->redirectToRoute('back_project_browse');
    }
}
