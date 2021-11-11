<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/user", name="back_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{id}", name="read")
     */
    public function read(User $user): Response
    {
        return $this->render('back/user/read.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', 'Utilisateur modifié');

            return $this->redirectToRoute('back_user_read', ['id' => $user->getId()]);
        }

        return $this->render('back/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
