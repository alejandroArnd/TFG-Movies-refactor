<?php

namespace App\Tests\Application\Service;

use PHPUnit\Framework\TestCase;
use App\Application\Service\ManageUploadFileService;

class ManageUploadFileServiceTest extends TestCase
{
    private ManageUploadFileService $manageUploadFile;
    private string $pathToUpload;

    public function setUp(): void
    {
        $this->manageUploadFile = new ManageUploadFileService();
        $this->pathToUpload = 'uploadMovieImages/';
    }

    public function testUploadFileFromBase64()
    {
        $movie = json_decode('{
            "title" : "samle",
            "releaseDate" : "2021-02-02", 
            "duration" : 5000000, 
            "overview" : "example", 
            "genres" : ["Action", "War"],
            "image" : ""
        }');

        $movie->image = "9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMDAsKCwsNDhIQDQ4RDgs
        LEBYQERMUFRUVDA8XGBYUGBIUFRT/2wBDAQMEBAUEBQkFBQkUDQsNFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQU
        FBQUFBQUFBQUFBQUFBT/wAARCAABAAEDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDA
        wIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISU
        pTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19j
        Z2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3
        AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZ
        GVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6On
        q8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD8rKKKKAP/2Q==";

        $titleOfFile = hash('md5', serialize($movie)).'.jpg';

        $accessiblePathExpected = 'http://localhost:9090/files/'.$titleOfFile;

        $accessiblePathReturned = $this->manageUploadFile->uploadFileFromBase64($this->pathToUpload, $movie);

        $this->assertEquals($accessiblePathExpected, $accessiblePathReturned);

        $this->assertFileExists('uploadMovieImages/'.$titleOfFile);

        unlink('uploadMovieImages/'.$titleOfFile);
    }
}