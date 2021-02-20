<?php

namespace App\Infrastructure\Controller;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\UseCases\Movies\CreateMovie;
use App\Application\Service\ValidatorMovieService;
use App\Application\UseCases\Movies\FindAllMovies;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoviesController extends AbstractController{

    private FindAllMovies $findAllMovies;
    private CreateMovie $createMovie;
    private ValidatorMovieService $validatorMovie;

    public function __construct(FindAllMovies $findAllMovies, CreateMovie $createMovie, ValidatorMovieService $validatorMovie)
    {
        $this->findAllMovies = $findAllMovies;
        $this->createMovie = $createMovie;
        $this->validatorMovie = $validatorMovie;
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
        try{
            $movie = json_decode($request->getContent());
            $this->validatorMovie->validate($movie);
            $this->createMovie->handle($movie);
            return new JsonResponse("Movie created!", JsonResponse::HTTP_OK);
        }catch(Exception $exception){
            return new JsonResponse($exception->errorMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }

}