<?php

namespace App\Tests\Application\UseCase\Movies;

use App\Domain\Model\UserModel;
use PHPUnit\Framework\TestCase;
use App\Application\UseCases\User\CreateUser;
use App\Application\Repository\UserRepository;
use App\Domain\Exception\EmailAlreadyInUseException;
use App\Domain\Exception\UsernameAlreadyExistException;

class CreateUserTest extends TestCase
{
    private UserRepository $userRepository;
    private CreateUser $createUser;

    public function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->createUser = new CreateUser($this->userRepository);
    }

    public function testCreateUserCorrectly(): void
    {
        $user = json_decode('{
            "username" : "alex",
            "password" : "1234", 
            "email" : "alex@gmail.com"
        }');

        $userModel = new UserModel($user->username, $user->email);

        $this->userRepository->expects($this->once())
            ->method('findByUsername')
            ->with($user->username);
        
        $this->userRepository->expects($this->once())
            ->method('findByEmail')
            ->with($user->email);
        
        $this->userRepository->expects($this->once())
            ->method('save')
            ->with($userModel, $user->password);
          
        $this->createUser->handle($user);
    }

    public function testCreateUserWhenUsernameAlreadyExist(): void
    {
        $user = json_decode('{
            "username" : "alex",
            "password" : "1234", 
            "email" : "alex@gmail.com"
        }');


        $userModel = $this->createMock(UserModel::class);

        $this->userRepository->expects($this->once())
            ->method('findByUsername')
            ->with($user->username)
            ->willReturn($userModel);
        
        $this->userRepository->expects($this->never())
            ->method('findByEmail');
        
        $this->userRepository->expects($this->never())
            ->method('save');
        
        $this->expectException(UsernameAlreadyExistException::class);
          
        $this->createUser->handle($user);
    }

    public function testCreateUserWhenEmailAlreadyExist(): void
    {
        $user = json_decode('{
            "username" : "alex",
            "password" : "1234", 
            "email" : "alex@gmail.com"
        }');

        $userModel = $this->createMock(UserModel::class);

        $this->userRepository->expects($this->once())
            ->method('findByUsername')
            ->with($user->username);
        
        $this->userRepository->expects($this->once())
            ->method('findByEmail')
            ->with($user->email)
            ->willReturn($userModel);
        
        $this->userRepository->expects($this->never())
            ->method('save');
        
        $this->expectException(EmailAlreadyInUseException::class);
          
        $this->createUser->handle($user);
    }
}
