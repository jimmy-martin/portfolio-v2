<?php

namespace App\Service;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function createFileName(UploadedFile $uploadedFile): string
    {
        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        $safeFileName = strtolower($this->slugger->slug($originalFileName));

        return $safeFileName . '.' . $uploadedFile->guessExtension();
    }

    public function createMailImageFileName(): string
    {
        return 'logo-email.png';
    }

    public function upload(Form $form, string $fileFieldName, $isMailImage = false): string
    {
        $file = $form->get($fileFieldName)->getData();

        if ($isMailImage) {
            $newFileName = $this->createMailImageFileName($file);
        } else {
            $newFileName = $this->createFileName($file);
        }

        $file->move(
            'assets/img',
            $newFileName
        );

        return $newFileName;
    }

    public function uploadProjectImage(Form $form)
    {
        $project = $form->getData();

        $newFileName = $this->upload($form, 'image');

        if ($newFileName) {
            $project->setImage($newFileName);
        }
    }

    public function uploadMailImage(Form $form)
    {
        $this->upload($form, 'image', true);
    }
}
