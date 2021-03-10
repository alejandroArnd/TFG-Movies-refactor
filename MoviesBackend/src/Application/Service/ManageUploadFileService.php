<?php

namespace App\Application\Service;

class ManageUploadFileService
{
    public function uploadFileFromBase64(string $pathToUpload, object $movie): string
    {
        $titleOfFile = hash('md5', serialize($movie)).'.jpg';
        file_put_contents($pathToUpload.$titleOfFile, base64_decode($movie->image)); 

        return $this->createAccessiblePath($titleOfFile);
    }

    public function createAccessiblePath($titleOfFile): string
    {
        return 'http://localhost:9090/files/'.$titleOfFile;
    }
}