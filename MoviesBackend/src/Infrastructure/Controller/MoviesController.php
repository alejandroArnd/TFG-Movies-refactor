<?php

namespace App\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\UseCases\Movies\CreateMovie;
use App\Application\UseCases\Movies\FindAllMovies;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoviesController extends AbstractController{

    private FindAllMovies $findAllMovies;
    private CreateMovie $createMovie;

    public function __construct(FindAllMovies $findAllMovies, CreateMovie $createMovie)
    {
        $this->findAllMovies = $findAllMovies;
        $this->createMovie = $createMovie;
    }

    /**
     * @Route("/movies", methods={"GET"})
     */
    public function findAllMovies(): JsonResponse
    {
        return new JsonResponse(
            $this->findAllMovies->handle()
        );
    }

     /**
     * @Route("/movies", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        $this->createMovie->handle(json_decode($request->getContent()));
        return new JsonResponse("dfw", JsonResponse::HTTP_OK);
    }

}