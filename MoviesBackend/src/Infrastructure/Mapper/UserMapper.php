<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\UserModel;
use App\Infrastructure\Entity\User;

class UserMapper extends AbstractDataMapper
{
    public function toEntity(UserModel $userModel): ?User
    {
        $user = new User(
            $userModel->getUsername(), 
            $userModel->getEmail(), 
        );

        return $user;
    }
}