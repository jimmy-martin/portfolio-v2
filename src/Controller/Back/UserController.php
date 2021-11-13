<?php

namespace App\Controller\Back;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/admin/user", name="back_user_")
 */
class UserController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/{id}", name="read")
     */
    public function read(): Response
    {
        return $this->render('back/user/read.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(User $user, Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plainTextPassword = $form->get('password')->getData();

            if ($plainTextPassword !== null) {
                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $plainTextPassword
                );

                $user->setPassword($hashedPassword);
            }

            $this->manager->flush();

            $this->addFlash('success', 'Utilisateur modifié');

            return $this->redirectToRoute('back_user_read', ['id' => $user->getId()]);
        }

        return $this->render('back/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
