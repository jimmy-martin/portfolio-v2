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

    public function upload(Form $form, string $fileFieldName): string
    {
        $file = $form->get($fileFieldName)->getData();

        $newFileName = $this->createFileName($file);

        $file->move(
            'img',
            $newFileName
        );

        return $newFileName;
    }
}