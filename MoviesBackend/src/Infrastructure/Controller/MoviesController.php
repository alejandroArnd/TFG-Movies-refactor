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
use App\Application\UseCases\Movies\FindMoviesByTitle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoviesController extends AbstractController{

    private FindAllMovies $findAllMovies;
    private CreateMovie $createMovie;
    private SoftDeleteMovie $softDeteleMovie;
    private ValidatorMovieService $validatorMovie;
    private FindMoviesByTitle $findMoviesByTitle;

    public function __construct(
        FindAllMovies $findAllMovies, 
        CreateMovie $createMovie, 
        SoftDeleteMovie $softDeteleMovie, 
        findMoviesByTitle $findMoviesByTitle,
        ValidatorMovieService $validatorMovie
    ){
        $this->findAllMovies = $findAllMovies;
        $this->createMovie = $createMovie;
        $this->softDeteleMovie = $softDeteleMovie;
        $this->findMoviesByTitle = $findMoviesByTitle;
        $this->validatorMovie = $validatorMovie;
    }

    /**
     * @Route("/api/movies", methods={"GET"})
     */
    public function findAllMovies(): JsonResponse
    {
        return new JsonResponse(
            $this->findAllMovies->handle()
        );
    }

     /**
     * @Route("/api/movies", methods={"POST"})
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
     * @Route("/api/movies/{id}", methods={"DELETE"})
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

    
     /**
     * @Route("/api/movies/{title}", methods={"POST"})
     */
    public function findMoviesByTitle (Request $request, string $title): JsonResponse
    {
        $movies = $this->findMoviesByTitle->handle($title);
        return new JsonResponse($movies, JsonResponse::HTTP_OK);
    }
    
}