<?php

namespace App\Controller\Back;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
