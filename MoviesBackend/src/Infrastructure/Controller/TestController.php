<?php

namespace App\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class TestController extends AbstractController{

    /**
     * @Route("/test", methods={"GET"})
     */
    public function test(): JsonResponse
    {
        return new JsonResponse("test");
    }

}