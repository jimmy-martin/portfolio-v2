<?php

namespace App\Controller\Back;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/skill", name="back_skill_", requirements={"id"="\d+"})
 */
class SkillController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("", name="browse")
     */
    public function browse(SkillRepository $skillRepository): Response
    {
        return $this->render('back/skill/browse.html.twig', [
            'skills' => $skillRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        $skill = new Skill();

        $form = $this->createForm(SkillType::class, $skill);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($skill);
            $this->manager->flush();

            $this->addFlash('success', 'La compétence a bien été ajoutée');

            if ($form->get('add_again')->isClicked()) {
                return $this->redirectToRoute('back_skill_add');
            }

            return $this->redirectToRoute('back_skill_browse');
        }

        return $this->render('back/skill/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Skill $skill)
    {
        $form = $this->createForm(SkillType::class, $skill);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            $this->addFlash('success', 'La compétence a bien été modifiée');

            return $this->redirectToRoute('back_skill_browse');
        }

        return $this->render('back/skill/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Skill $skill)
    {
        $submittedAntiCSRFToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete_skill' . $skill->getId(), $submittedAntiCSRFToken)) {
            $this->manager->remove($skill);
            $this->manager->flush();

            $this->addFlash('success', 'La compétence a bien été supprimée');

            return $this->redirectToRoute('back_skill_browse');
        }

        $this->addFlash('danger', 'Une erreur est survenue lors de la suppression');

        return $this->redirectToRoute('back_skill_browse');
    }
}
