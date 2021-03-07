<?php

namespace App\Application\Service;

use App\Domain\Exception\UsernameLengthException;
use App\Domain\Exception\EmailIsNotValidException;

class ValidatorUserService
{
    public function validate($user)
    {
        if(strlen($user->username) > 100){
            throw new UsernameLengthException();
        }

        if(!filter_var($user->email, FILTER_VALIDATE_EMAIL)){
            throw new EmailIsNotValidException();
        }
    }
}