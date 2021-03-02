<?php

namespace App\Infrastructure\Controller;

use Exception;
use App\Application\UseCases\User\CreateUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\Service\ValidatorUserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class UserController extends AbstractController
{
    private CreateUser $createUser;
    private ValidatorUserService $validatorUserService;
    
    public function __construct(
        CreateUser $createUser,
        ValidatorUserService $validatorUserService
    ){
        $this->createUser = $createUser;
        $this->validatorUserService = $validatorUserService;
    }

     /**
     * @Route("/api/register", methods={"POST"})
     */
    public function register(Request $request): JsonResponse
    {
        try{
            $user = json_decode($request->getContent());
            $this->validatorUserService->validate($user);
            $this->createUser->handle($user);
            return new JsonResponse('User was created', JsonResponse::HTTP_OK);
        }catch(Exception $exception){
            return new JsonResponse($exception->errorMessage(), JsonResponse::HTTP_BAD_REQUEST);
        }
    }

        /**
     * @Route("/api/login", methods={"POST"})
     */
    public function login(UserInterface $user, JWTTokenManagerInterface $JWTTokenManager): JsonResponse
    {
        return new JsonResponse(['token' => $jwtManager->create($user)], JsonResponse::HTTP_OK);
    }
}