<?php

namespace App\Application\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader implements FileUploaderInterface
{
    private string $ticketAttachmentPath;

    public function __construct(string $ticketAttachmentPath)
    {
        $this->ticketAttachmentPath = $ticketAttachmentPath;
    }
    
    public function upload(UploadedFile $file, int $id): void
    {
        $explodedName = explode('.', $file->getClientOriginalName());
        $extension = end($explodedName);
        $filePath = $this->ticketAttachmentPath;
        $fileName = $id . '.' . $extension;
        $file->move($filePath, $fileName);
    }
}