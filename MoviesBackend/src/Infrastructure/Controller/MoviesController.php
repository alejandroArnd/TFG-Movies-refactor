<?php

namespace App\Infrastructure\Controller;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\UseCases\Movies\CreateMovie;
use App\Application\Service\ValidatorMovieService;
use App\Application\UseCases\Movies\FindAllMovies;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\UseCases\Movies\SoftDeleteMovie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoviesController extends AbstractController{

    private FindAllMovies $findAllMovies;
    private CreateMovie $createMovie;
    private SoftDeleteMovie $softDeteleMovie;
    private ValidatorMovieService $validatorMovie;

    public function __construct(
        FindAllMovies $findAllMovies, 
        CreateMovie $createMovie, 
        SoftDeleteMovie $softDeteleMovie, 
        ValidatorMovieService $validatorMovie
    ){
        $this->findAllMovies = $findAllMovies;
        $this->createMovie = $createMovie;
        $this->softDeteleMovie = $softDeteleMovie;
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

     /**
     * @Route("/movies/{id}", methods={"DELETE"})
     */
    public function delete(int $id): JsonResponse
    {
        try{
            $this->softDeteleMovie->handle($id);
            return new JsonResponse("Movie was deleted", JsonResponse::HTTP_OK);
        }catch(Exception $exception){
            return new JsonResponse($exception->errorMessage(), JsonResponse::HTTP_NOT_FOUND);
        }
    }
}