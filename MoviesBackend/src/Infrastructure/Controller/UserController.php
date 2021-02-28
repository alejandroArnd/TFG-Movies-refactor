<?php

namespace App\Infrastructure\Controller;

use Exception;
use App\Application\UseCases\User\CreateUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\UseCases\Review\CreateReview;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private CreateReview $createReview;
    private CreateUser $createUser;
    
    public function __construct(
        CreateReview $createReview,
        CreateUser $createUser
    ){
        $this->createReview = $createReview;
        $this->createUser = $createUser;
    }

     /**
     * @Route("/api/register", methods={"POST"})
     */
    public function register(Request $request): JsonResponse
    {
        try{
            $user = json_decode($request->getContent());
            $this->createUser->handle($user);
            return new JsonResponse('User was created', JsonResponse::HTTP_OK);
        }catch(Exception $exception){
            return new JsonResponse($exception->getMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}