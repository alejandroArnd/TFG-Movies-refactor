<?php

namespace App\Application\UseCases\User;

use App\Domain\Model\UserModel;
use App\Application\Repository\UserRepository;

class CreateUser
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle($user): void
    {
        $userModel = new UserModel($user->username, $user->email);
        $this->userRepository->save($userModel, $user->password);
    }
}