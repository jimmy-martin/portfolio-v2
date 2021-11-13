<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    /**
     * @Route("/back/skill", name="back_skill")
     */
    public function index(): Response
    {
        return $this->render('back/skill/index.html.twig', [
            'controller_name' => 'SkillController',
        ]);
    }
}
