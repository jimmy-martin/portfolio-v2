<?php

namespace App\Controller\Back;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/category", name="back_category_", requirements={"id"="\d+"})
 */
class CategoryController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("", name="browse")
     */
    public function browse(CategoryRepository $categoryRepository): Response
    {
        return $this->render('back/category/browse.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($category);
            $this->manager->flush();

            $this->addFlash('success', 'La catégorie a bien été ajoutée');

            return $this->redirectToRoute('back_category_browse');

            // TODO: ajouter la possibilité d'ajouter et de revenir sur le formulaire d'ajout au lieu de rediriger sur la page browse
        }

        return $this->render('back/category/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Request $request, Category $category)
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();

            $this->addFlash('success', 'La catégorie a bien été modifiée');

            return $this->redirectToRoute('back_category_browse');
        }

        return $this->render('back/category/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Category $category)
    {
        $submittedAntiCSRFToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete_category' . $category->getId(), $submittedAntiCSRFToken)) {
            $this->manager->remove($category);
            $this->manager->flush();

            $this->addFlash('success', 'La catégorie a bien été supprimée');

            return $this->redirectToRoute('back_category_browse');
        }

        $this->addFlash('danger', 'Une erreur est survenue lors de la suppression');

        return $this->redirectToRoute('back_category_browse');
    }
}
