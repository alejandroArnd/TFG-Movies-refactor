<?php

namespace App\Application\Repository;

use App\Domain\Model\UserModel;

interface UserRepository
{
    public function save(UserModel $user, string $plainPassword): void;

    public function findByEmail(string $email): ?UserModel;
    
    public function findByUsername(string $username): ?UserModel;
}
