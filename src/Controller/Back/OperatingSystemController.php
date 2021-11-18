<?php

namespace App\Controller\Back;

use App\Entity\OperatingSystem;
use App\Form\OperatingSystemType;
use App\Repository\OperatingSystemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/operating_system", name="back_operating_system_", requirements={"id"="\d+"})
 */
class OperatingSystemController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("", name="browse")
     */
    public function browse(OperatingSystemRepository $operatingSystemRepository): Response
    {
        return $this->render('back/operating_system/browse.html.twig', [
            'operatingSystems' => $operatingSystemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        $operatingSystem = new OperatingSystem();

        $form = $this->createForm(OperatingSystemType::class, $operatingSystem);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($operatingSystem);
            $this->manager->flush();

            $this->addFlash('success', 'Le système d\'exploitation a bien été ajouté');

            return $this->redirectToRoute('back_operating_system_browse');

            // TODO: ajouter la possibilité d'ajouter et de revenir sur le formulaire d'ajout au lieu de rediriger sur la page browse
        }

        return $this->render('back/operating_system/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, OperatingSystem $operatingSystem)
    {
        $form = $this->createForm(OperatingSystemType::class, $operatingSystem);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            $this->addFlash('success', 'Le système d\'exploitation a bien été modifié');

            return $this->redirectToRoute('back_operating_system_browse');
        }

        return $this->render('back/operating_system/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, OperatingSystem $operatingSystem)
    {
        $submittedAntiCSRFToken = $request->request->get('_token');

        if($this->isCsrfTokenValid('delete_operating_system' . $operatingSystem->getId(), $submittedAntiCSRFToken)) {
            $this->manager->remove($operatingSystem);
            $this->manager->flush();

            $this->addFlash('success', 'Le système d\'exploitation a bien été supprimé');

            return $this->redirectToRoute('back_operating_system_browse');
        }

        $this->addFlash('danger', 'Une erreur est survenue lors de la suppression');

        return $this->redirectToRoute('back_operating_system_browse');
    }
}
