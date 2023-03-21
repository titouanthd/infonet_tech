<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImageService
{
    private string $uploadsDirectory;

    public function __construct(string $uploadsDirectory)
    {
        $this->uploadsDirectory = $uploadsDirectory;
    }

    public function upload(UploadedFile $file): string
    {
        $fileName = uniqid().'.'.$file->guessExtension();
        $file->move($this->uploadsDirectory, $fileName);

        return $this->uploadsDirectory.'/'.$fileName;
    }
}