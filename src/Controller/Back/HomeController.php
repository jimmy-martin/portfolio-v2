<?php

namespace App\Controller\Back;

use App\Form\MailImageType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/admin/", name="back_home")
     */
    public function browse(): Response
    {
        return $this->render('back/home/browse.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/admin/mail-image", name="back_home_mail_image")
     */
    public function changeMailImage(FileUploader $fileUploader, Request $request): Response
    {
        $form = $this->createForm(MailImageType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fileUploader->uploadMailImage($form);

            $this->addFlash('success', 'L\'image du mail de confirmation a bien été modifiée.');
        }

        return $this->render('back/home/mail_image.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
