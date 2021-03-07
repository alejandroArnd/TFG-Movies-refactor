<?php

namespace App\Tests\Application\Service;

use PHPUnit\Framework\TestCase;
use App\Application\Service\ValidatorUserService;
use App\Domain\Exception\UsernameLengthException;
use App\Domain\Exception\EmailIsNotValidException;

class ValidatorUserServiceTest extends TestCase
{
    private ValidatorUserService $validatorUser;

    public function setUp(): void
    {
        $this->validatorUser = new ValidatorUserService();
    }

    public function testvalidateUserWhenEmailIsNotValid(): void
    {
        $user = json_decode('{
            "username" : "alex",
            "password" : "1234", 
            "email" : "alexgmail.com"
        }');

        $this->expectException(EmailIsNotValidException::class);

        $this->validatorUser->validate($user);
    }

    public function testvalidateUserWhenUsernameHasMore100Characters(): void
    {
        $user = json_decode('{
            "username" : "alexalexalexalexalexalexalexalexalexalexalexalexalexa",
            "password" : "1234", 
            "email" : "alex@gmail.com"
        }');

        $this->expectException(UsernameLengthException::class);

        $this->validatorUser->validate($user);
    }
}