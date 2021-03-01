<?php

namespace App\Application\UseCases\User;

use App\Domain\Model\UserModel;
use App\Application\Repository\UserRepository;
use App\Domain\Exception\EmailAlreadyInUseException;
use App\Domain\Exception\UsernameAlreadyExistException;

class CreateUser
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle($user): void
    {
        $userFound = $this->userRepository->findByUsername($user->username);
        if($userFound){
            throw new UsernameAlreadyExistException();
        }

        $userFound = $this->userRepository->findByEmail($user->email);
        if($userFound){
            throw new EmailAlreadyInUseException();
        }

        $userModel = new UserModel($user->username, $user->email);
        $this->userRepository->save($userModel, $user->password);
    }
}