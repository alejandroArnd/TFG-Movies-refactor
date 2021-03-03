<?php

namespace App\Infrastructure\Controller;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\UseCases\Movies\CreateMovie;
use App\Application\UseCases\Movies\UpdateMovie;
use App\Application\Service\ValidatorMovieService;
use App\Application\UseCases\Movies\FindAllMovies;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\UseCases\Movies\SoftDeleteMovie;
use App\Application\UseCases\Movies\FindMoviesByTitle;
use App\Application\UseCases\Movies\FindOneMovieByTitle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoviesController extends AbstractController{

    private FindAllMovies $findAllMovies;
    private CreateMovie $createMovie;
    private SoftDeleteMovie $softDeteleMovie;
    private ValidatorMovieService $validatorMovie;
    private FindMoviesByTitle $findMoviesByTitle;
    private UpdateMovie $updateMovie;
    private FindOneMovieByTitle $findOneMoviesByTitle;

    public function __construct(
        FindAllMovies $findAllMovies, 
        CreateMovie $createMovie, 
        SoftDeleteMovie $softDeteleMovie, 
        FindMoviesByTitle $findMoviesByTitle,
        FindOneMovieByTitle $findOneMoviesByTitle,
        UpdateMovie $updateMovie,
        ValidatorMovieService $validatorMovie
    ){
        $this->findAllMovies = $findAllMovies;
        $this->createMovie = $createMovie;
        $this->softDeteleMovie = $softDeteleMovie;
        $this->findMoviesByTitle = $findMoviesByTitle;
        $this->findOneMoviesByTitle = $findOneMoviesByTitle;
        $this->updateMovie = $updateMovie;
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
            $messageError = ['message' => $exception->getMessage(), 'status' => $exception->getCode()];
            return new JsonResponse($messageError, $exception->getCode());
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
            $messageError = ['message' => $exception->getMessage(), 'status' => $exception->getCode()];
            return new JsonResponse($messageError, $exception->getCode());
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

    /**
     * @Route("/api/movies/{title}", methods={"GET"})
     */
    public function findOneMovieByTitle (string $title): JsonResponse
    {
        $movies = $this->findOneMoviesByTitle->handle($title);
        return new JsonResponse($movies, JsonResponse::HTTP_OK);
    }

     /**
     * @Route("/api/movies", methods={"PUT"})
     */
    public function update (Request $request): JsonResponse
    {
        try{
            $movie = json_decode($request->getContent());
            $this->validatorMovie->validate($movie);
            $this->updateMovie->handle($movie);
            return new JsonResponse("Movie was updated!", JsonResponse::HTTP_OK);
        }catch(Exception $exception){
            $messageError = ['message' => $exception->getMessage(), 'status' => $exception->getCode()];
            return new JsonResponse($messageError, $exception->getCode());
        }
    }
    
}