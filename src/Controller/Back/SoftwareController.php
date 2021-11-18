<?php

namespace App\Controller\Back;

use App\Entity\Software;
use App\Form\SoftwareType;
use App\Repository\SoftwareRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/software", name="back_software_", requirements={"id"="\d+"})
 */
class SoftwareController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("", name="browse")
     */
    public function browse(SoftwareRepository $softwareRepository): Response
    {
        return $this->render('back/software/browse.html.twig', [
            'softwares' => $softwareRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        $software = new Software();

        $form = $this->createForm(SoftwareType::class, $software);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($software);
            $this->manager->flush();

            $this->addFlash('success', 'Le logiciel a bien été ajouté');

            return $this->redirectToRoute('back_software_browse');

            // TODO: ajouter la possibilité d'ajouter et de revenir sur le formulaire d'ajout au lieu de rediriger sur la page browse
        }

        return $this->render('back/software/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Software $software)
    {
        $form = $this->createForm(SoftwareType::class, $software);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            $this->addFlash('success', 'Le logiciel a bien été modifié');

            return $this->redirectToRoute('back_software_browse');
        }

        return $this->render('back/software/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Software $software)
    {
        $submittedAntiCSRFToken = $request->request->get('_token');

        if($this->isCsrfTokenValid('delete_software' . $software->getId(), $submittedAntiCSRFToken)) {
            $this->manager->remove($software);
            $this->manager->flush();

            $this->addFlash('success', 'Le logiciel a bien été supprimé');

            return $this->redirectToRoute('back_software_browse');
        }

        $this->addFlash('danger', 'Une erreur est survenue lors de la suppression');

        return $this->redirectToRoute('back_software_browse');
    }
}
