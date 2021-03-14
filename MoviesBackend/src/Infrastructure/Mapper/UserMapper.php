<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\UserModel;
use App\Infrastructure\Entity\User;

class UserMapper extends AbstractDataMapper
{
    public function toEntity(UserModel $userModel): ?User
    {
        return new User(
            $userModel->getUsername(), 
            $userModel->getEmail(), 
        );
    }

    public function toModel(User $user) : ?UserModel
    {
        $userModel = new UserModel($user->getUsername(), $user->getEmail(), $user->getRoles(), $user->getId());
        $userModel->setPassword($user->getPassword());

        return $userModel;
    }
}