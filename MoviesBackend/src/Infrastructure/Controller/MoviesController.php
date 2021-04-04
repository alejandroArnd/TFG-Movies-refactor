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
use App\Application\UseCases\Movies\FindTopRatedMovies;
use App\Application\UseCases\Movies\FindOneMovieByTitle;
use App\Application\UseCases\Movies\FindComingSoonMovies;
use App\Application\UseCases\Movies\FindMostPopularMovies;
use App\Application\UseCases\Movies\FindMoviesBySeveralCriterias;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MoviesController extends AbstractController{

    private FindAllMovies $findAllMovies;
    private CreateMovie $createMovie;
    private SoftDeleteMovie $softDeteleMovie;
    private ValidatorMovieService $validatorMovie;
    private FindMoviesBySeveralCriterias $findMoviesBySeveralCriterias;
    private UpdateMovie $updateMovie;
    private FindOneMovieByTitle $findOneMoviesByTitle;
    private FindTopRatedMovies $findTopRatedMovies;
    private FindComingSoonMovies $findComingSoonMovies;
    private FindMostPopularMovies $findMostPopularMovies;

    public function __construct(
        FindAllMovies $findAllMovies, 
        CreateMovie $createMovie, 
        SoftDeleteMovie $softDeteleMovie, 
        FindMoviesBySeveralCriterias $findMoviesBySeveralCriterias,
        FindOneMovieByTitle $findOneMoviesByTitle,
        UpdateMovie $updateMovie,
        ValidatorMovieService $validatorMovie,
        FindTopRatedMovies $findTopRatedMovies,
        FindComingSoonMovies $findComingSoonMovies,
        FindMostPopularMovies $findMostPopularMovies
    ){
        $this->findAllMovies = $findAllMovies;
        $this->createMovie = $createMovie;
        $this->softDeteleMovie = $softDeteleMovie;
        $this->findMoviesBySeveralCriterias = $findMoviesBySeveralCriterias;
        $this->findOneMoviesByTitle = $findOneMoviesByTitle;
        $this->updateMovie = $updateMovie;
        $this->validatorMovie = $validatorMovie;
        $this->findTopRatedMovies = $findTopRatedMovies;
        $this->findComingSoonMovies = $findComingSoonMovies;
        $this->findMostPopularMovies = $findMostPopularMovies;
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
     * @Route("/api/movies/search", methods={"GET"})
     */
    public function findMoviesBySeveralCriterias (Request $request): JsonResponse
    {
        $criteriaParams= json_decode (json_encode ($request->query->all()), false);
        $movies = $this->findMoviesBySeveralCriterias->handle($criteriaParams);
        return new JsonResponse($movies, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/api/movies/{title}", methods={"GET"})
     */
    public function findOneMovieByTitle (string $title): JsonResponse
    {
        try{
            $movies = $this->findOneMoviesByTitle->handle($title);
            return new JsonResponse($movies, JsonResponse::HTTP_OK);
        }catch(Exception $exception){
            $messageError = ['message' => $exception->getMessage(), 'status' => $exception->getCode()];
            return new JsonResponse($messageError, $exception->getCode());
        }
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

    /**
     * @Route("/api/movies/top/rated", methods={"GET"})
     */
    public function findTopRatedMovies (): JsonResponse
    {
        $movies = $this->findTopRatedMovies->handle();
        return new JsonResponse($movies, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/api/movies/coming/soon", methods={"GET"})
     */
    public function findComingSoonMovies(): JsonResponse
    {
        $movies = $this->findComingSoonMovies->handle();
        return new JsonResponse($movies, JsonResponse::HTTP_OK);
    }

    /**
     * @Route("/api/movies/most/popular", methods={"GET"})
     */
    public function findMostPopularMovies(): JsonResponse
    {
        $movies = $this->findMostPopularMovies->handle();
        return new JsonResponse($movies, JsonResponse::HTTP_OK);
    }
    
}