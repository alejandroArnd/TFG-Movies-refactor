<?php

namespace App\Application\Repository;

use App\Domain\Model\UserModel;

interface UserRepository
{
    public function save(UserModel $user): void;
    
}
