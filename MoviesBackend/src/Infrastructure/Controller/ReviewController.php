<?php

namespace App\Infrastructure\Controller;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\UseCases\Review\CreateReview;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\Service\ValidatorReviewService;
use App\Application\UseCases\Review\FindReviewsByIdMovie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewController extends AbstractController
{
    private CreateReview $createReview;
    private FindReviewsByIdMovie $findReviewsByIdMoview;
    private ValidatorReviewService $validatorReviewService;
    
    public function __construct(
        CreateReview $createReview, 
        FindReviewsByIdMovie $findReviewsByIdMovie, 
        ValidatorReviewService $validatorReviewService
    ){
        $this->createReview = $createReview;
        $this->findReviewsByIdMovie = $findReviewsByIdMovie;
        $this->validatorReviewService = $validatorReviewService;
    }

     /**
     * @Route("/api/review", methods={"POST"})
     */
    public function create(Request $request): JsonResponse
    {
        try{
            $review = json_decode($request->getContent());
            $this->validatorReviewService->validate($review);
            $this->createReview->handle($review);
            return new JsonResponse("Review created!", JsonResponse::HTTP_OK);
        }catch(Exception $exception){
            return new JsonResponse($exception->errorMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }

     /**
     * @Route("/api/review/{movieId}", methods={"GET"})
     */
    public function findReviewsByMovieId(int $movieId): JsonResponse
    {
        try{
            $reviews = $this->findReviewsByIdMovie->handle($movieId);
            return new JsonResponse($reviews, JsonResponse::HTTP_OK);
        }catch(Exception $exception){
            return new JsonResponse($exception->getMessage(), JsonResponse::HTTP_NOT_FOUND);
        }
    }

    
}